from pathlib import Path
import PyPDF2

# === CONFIGURE THIS ===
known_part = "RAVI"  # Your known password prefix

# Full absolute path to your PDF file
pdf_path = "/Users/moinshadab/Downloads/Yes_Bank_Account_Application.pdf"

def try_passwords(pdf_path, known_part):
    path_obj = Path(pdf_path)
    if not path_obj.is_file():
        print(f"❌ File not found: {pdf_path}")
        return None
    else:
        print(f"📂 File found: {pdf_path}")

    pdf_file = open(pdf_path, "rb")
    reader = PyPDF2.PdfReader(pdf_file)
    
    for day in range(1, 32):
        for month in range(1, 13):
            dd = f"{day:02d}"
            mm = f"{month:02d}"
            password = known_part + dd + mm
            
            print(f"🔑 Trying password: {password} ...", end=" ")
            try:
                if reader.decrypt(password):
                    print("✅ Password correct!")
                    pdf_file.close()
                    return password
                else:
                    print("❌ Incorrect password.")
            except Exception as e:
                print(f"⚠️ Error during decryption: {e}")
                # Continue trying other combos even if error occurs

    print("❌ Password not found in the tried combinations.")
    pdf_file.close()
    return None

# Run the function
found_password = try_passwords(pdf_path, known_part)
if found_password:
    print(f"\n🎉 Password recovered successfully: {found_password}")
else:
    print("\n😞 Failed to recover the password.")
