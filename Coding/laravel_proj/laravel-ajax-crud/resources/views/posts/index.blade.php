<!DOCTYPE html>
<html>
<head>
    <title>Laravel AJAX CRUD</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>

<h2>Create New Post</h2>
<form id="postForm">
    <input type="hidden" id="post_id">
    <input type="text" id="title" placeholder="Title"><br>
    <textarea id="body" placeholder="Body"></textarea><br>
    <button type="submit">Submit</button>
</form>

<h2>Posts List</h2>
<table border="1" id="postTable">
    <thead>
        <tr>
            <th>Title</th><th>Body</th><th>Actions</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>

<script>
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function fetchPosts() {
    $.get('/posts/fetch', function(data) {
        let rows = '';
        $.each(data, function(i, post) {
            rows += `<tr>
                <td>${post.title}</td>
                <td>${post.body}</td>
                <td>
                    <button onclick="editPost(${post.id})">Edit</button>
                    <button onclick="deletePost(${post.id})">Delete</button>
                </td>
            </tr>`;
        });
        $('#postTable tbody').html(rows);
    });
}

fetchPosts();

$('#postForm').submit(function(e) {
    e.preventDefault();
    let id = $('#post_id').val();
    let method = id ? 'PUT' : 'POST';
    let url = id ? `/posts/${id}` : '/posts';
    
    $.ajax({
        url: url,
        type: method,
        data: {
            title: $('#title').val(),
            body: $('#body').val()
        },
        success: function(response) {
            $('#postForm')[0].reset();
            $('#post_id').val('');
            fetchPosts();
        }
    });
});

function editPost(id) {
    $.get(`/posts/${id}/edit`, function(post) {
        $('#post_id').val(post.id);
        $('#title').val(post.title);
        $('#body').val(post.body);
    });
}

function deletePost(id) {
    if (confirm('Are you sure?')) {
        $.ajax({
            url: `/posts/${id}`,
            type: 'DELETE',
            success: function(result) {
                fetchPosts();
            }
        });
    }
}
</script>

</body>
</html>
