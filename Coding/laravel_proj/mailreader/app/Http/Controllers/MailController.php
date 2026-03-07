<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Webklex\PHPIMAP\ClientManager;
use App\Models\Email;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MailController extends Controller
{
     public function fetchEmails(Request $request)
    {
        ini_set('max_execution_time', 600000);
        ini_set('memory_limit', '800M');

        $from = $request->from ?? now()->subMonth()->format('Y-m-d');
        $to   = $request->to ?? now()->format('Y-m-d');

        echo "Fetching emails from: $from to $to <br>";

        $cm = new ClientManager();
        $client = $cm->make([
            'host'          => 'imap.gmail.com',
            'port'          => 993,
            'encryption'    => 'ssl',
            'validate_cert' => true,

            'protocol'      => 'imap'
        ]);

        try {
            $client->connect();
            echo "✅ Connected to IMAP server<br>";
        } catch (\Exception $e) {
            echo "IMAP connection failed: " . $e->getMessage();
            return;
        }

        try {
            $folder = $client->getFolder('INBOX');
            echo "Folder found: " . $folder->name . "<br>";
        } catch (\Exception $e) {
            echo "Could not access folder: " . $e->getMessage();
            return;
        }

        $messages = $folder->messages()
            ->since($from)
            ->before($to)
            ->get();

        echo "Total messages found: " . $messages->count() . "<br><hr>";

        if ($messages->count() == 0) {
            echo "No emails found in this range.<br>";
            return;
        }

        foreach ($messages as $message) {
            try {
                // Decode headers safely
                $subject = mb_decode_mimeheader($message->getSubject());
                $from_email = $message->getFrom()[0]->mail ?? null;
                $from_name  = mb_decode_mimeheader($message->getFrom()[0]->personal ?? '');

                $body_html = mb_convert_encoding($message->getHTMLBody() ?: '', 'UTF-8', 'auto');
                $body_text = mb_convert_encoding($message->getTextBody() ?: '', 'UTF-8', 'auto');

                echo "<b>Subject:</b> {$subject}<br>";
                echo "<b>From:</b> {$from_email}<br>";
                echo "<b>Date:</b> {$message->getDate()}<br>";

                $email = Email::firstOrCreate(
                    ['message_id' => $message->getMessageId()],
                    [
                        'subject'    => $subject,
                        'from_email' => $from_email,
                        'from_name'  => $from_name,
                        'body_html'  => $body_html,
                        'body_text'  => $body_text,
                        'mail_date'  => $message->getDate()
                    ]
                );

                echo "Saved to DB (ID: {$email->id})<br>";

                $attachments = $message->getAttachments();

                // Replace inline images and handle attachments
                foreach ($attachments as $attachment) {
                    $attachment->save(public_path('attachments'));

                    // Detect inline by checking if HTML references this attachment
                    $cid = $attachment->getContentID() ?? null;
                    $is_inline = false;

                    if ($cid && strpos($body_html, 'cid:' . $cid) !== false) {
                        $is_inline = true;
                        // Replace <img src="cid:..."> with URL
                        $body_html = str_replace(
                            'src="cid:' . $cid . '"',
                            'src="' . asset('attachments/' . $attachment->name) . '"',
                            $body_html
                        );
                    } else {
                        // fallback: check if attachment name exists in HTML (Outlook Word HTML)
                        if (strpos($body_html, $attachment->name) !== false) {
                            $is_inline = true;
                            $body_html = str_replace(
                                $attachment->name,
                                asset('attachments/' . $attachment->name),
                                $body_html
                            );
                        }
                    }

                    DB::table('email_attachments')->insert([
                        'email_id'  => $email->id,
                        'filename'  => $attachment->name,
                        'path'      => 'attachments/' . $attachment->name,
                        'cid'       => $cid,
                        'is_inline' => $is_inline ? 1 : 0,
                        'created_at'=> now(),
                        'updated_at'=> now()
                    ]);

                    echo "Attachment saved and recorded: {$attachment->name} <br>";
                }

                // Update HTML after replacing inline images
                DB::table('emails')->where('id', $email->id)->update(['body_html' => $body_html]);

                echo "<hr>";

            } catch (\Exception $e) {
                echo "Email processing failed: " . $e->getMessage() . "<hr>";
                continue; // skip to next email
            }
        }

        echo "🎉 Emails import finished successfully!";
    }

public function showEmail($id) {
    $email = DB::table('emails')->where('id', $id)->first();
    $attachments = DB::table('email_attachments')
        ->where('email_id', $id)
        ->get();
    $html = $email->body_html;
    foreach ($attachments as $att) {
        if ($att->is_inline) {
            // Gmail often leaves cid in src, but the real file URL is in path
            $html = preg_replace(
                '/src=["\']cid:.*?["\']/', 
                'src="' . asset($att->path) . '"', 
                $html
            );
        }
    }
    $normalAttachments = $attachments->where('is_inline', 0);
    return view('emails.show', compact('email', 'html', 'normalAttachments'));
}

}