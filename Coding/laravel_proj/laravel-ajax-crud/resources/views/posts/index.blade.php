<!-- <!DOCTYPE html>
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

<h2>Posts Listt</h2>
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
    // alert(id);
    // return ;
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
</html>      -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gmail Clone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Google+Sans:wght@400;500;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gmail-red: #d93025;
            --gmail-light-gray: #f6f8fc;
            --gmail-gray: #eaf1fb;
            --gmail-dark-gray: #5f6368;
            --gmail-blue: #1a73e8;
            --gmail-hover: #f2f6fc;
            --gmail-border: #dadce0;
            --gmail-shadow: rgba(60, 64, 67, 0.15);
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--gmail-light-gray);
            color: #202124;
            height: 100vh;
            overflow: hidden;
        }

        .gmail-brand {
            font-family: 'Google Sans', sans-serif;
            font-weight: 500;
            color: #5f6368;
            font-size: 22px;
        }

        .gmail-logo {
            width: 40px;
            height: 40px;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0iI2Q5MzAyNSI+PHBhdGggZD0iTTIyLjI3NSA0LjM4OUMyMi44IDUuMDYgMjMgNi4wNjcgMjMgNy4xMTdWMTdDMjMgMTkuNzYgMjAuNzYgMjIgMTggMjJINkMzLjI0IDIyIDEgMTkuNzYgMSAxN1Y3QzEgNC4yNCAzLjI0IDIgNiAyaDkuODQyQzE1LjY4IDIgMTYuNyAyLjMgMTcuNTggMi44MzJsLTUuMzU0IDUuMzU0LS4wMDctLjAwN0MxMi4wMTIgOC4xMiAxMS41NTUgOC4xMTIgMTEuMTIgOC4yM0w2LjMzIDMuNDJhLjk4Ljk4IDAgMCAwIC0xLjQgMEwzLjQyIDQuOTNhLjk4Ljk4IDAgMCAwIDAgMS40bDQuMjIgNC4yMi0zLjk1IDMuOTVhLjk4Ljk4IDAgMCAwIDAgMS40bDEuNTEgMS41MWEuOTguOTggMCAwIDAgMS40IDBMMTIgMTMuMDJsNi4zNCA2LjM0YS45OC45OCAwIDAgMCAxLjQgMGwxLjUxLTEuNTEuMDEtLjAxYS45OC45OCAwIDAgMCAwLTEuNEwxNi4xMiAxMiA5LjYgNS40OGw1LjY0LTUuNjRhLjk4Ljk4IDAgMCAxIDEuNCAwbDEuNTEgMS41MWEuOTguOTggMCAwIDEgMCAxLjRMMTUuMzQgNS4zbDUuNjQgNS42NGEuOTguOTggMCAwIDEgMCAxLjRsLTEuNTEgMS41MWEuOTguOTggMCAwIDEtMS40IDBsLTQuOTQtNC45NC0uNzQuNzRhLjk4Ljk4IDAgMCAxLTEuNCAwbC0uNzQtLjc0LTUuNjQtNS42NGEuOTguOTggMCAwIDEgMC0xLjRMNy40Ni41MmEuOTguOTggMCAwIDEgMS40IDBMMTIgNC41MiAxNi41NC4wMEEuOTguOTggMCAwIDEgMTggMGguMDFhLjk4Ljk4IDAgMCAxIDEuNCAwbDEuNTEgMS41MWEuOTguOTggMCAwIDEgMCAxLjRMMTUuMzQgNS4zbDUuNjQgNS42NGEuOTguOTggMCAwIDEgMCAxLjRsLTEuNTEgMS41MWEuOTguOTggMCAwIDEtMS40IDBMMTIgMTMuMDIgNi40NiAxOC41NmEuOTguOTggMCAwIDEtMS40IDBMNC45NSAxNy4wNWEuOTguOTggMCAwIDEgMC0xLjRMMTAuNCAxMS4ybC0uNzQtLjc0YS45OC45OCAwIDAgMSAwLTEuNGwuNzQtLjc0IDUuNjQtNS42NGEuOTguOTggMCAwIDEgMS40IDBsNS42NCA1LjY0eiIvPjwvc3ZnPg==') center/contain no-repeat;
        }

        /* Top App Bar */
        .top-app-bar {
            height: 64px;
            background-color: white;
            border-bottom: 1px solid var(--gmail-border);
            box-shadow: 0 1px 2px 0 var(--gmail-shadow);
            z-index: 1000;
        }

        .search-bar {
            background-color: var(--gmail-gray);
            border-radius: 8px;
            padding: 0 16px;
            max-width: 720px;
            height: 49px;
        }

        .search-bar input {
            background: transparent;
            border: none;
            outline: none;
            width: 100%;
            font-size: 16px;
        }

        .search-bar input::placeholder {
            color: var(--gmail-dark-gray);
        }

        .top-action-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: var(--gmail-dark-gray);
            transition: background-color 0.2s;
        }

        .top-action-btn:hover {
            background-color: var(--gmail-hover);
        }

        /* Main Layout */
        .main-container {
            height: calc(100vh - 64px);
        }

        /* Sidebar */
        .sidebar {
            width: 256px;
            background-color: white;
            transition: all 0.3s;
            overflow-y: auto;
        }

        .compose-btn {
            border-radius: 16px;
            height: 56px;
            box-shadow: 0 1px 2px 0 rgba(60,64,67,0.3), 0 1px 3px 1px rgba(60,64,67,0.15);
            font-weight: 500;
            letter-spacing: 0.25px;
            padding: 0 24px 0 16px;
            margin: 8px 8px 16px 8px;
        }

        .compose-btn:hover {
            box-shadow: 0 1px 3px 0 rgba(60,64,67,0.3), 0 4px 8px 3px rgba(60,64,67,0.15);
            background-color: #fafafb;
        }

        .nav-item {
            height: 32px;
            border-radius: 0 16px 16px 0;
            padding: 0 12px 0 26px;
            margin-right: 8px;
            font-size: 14px;
            color: var(--gmail-dark-gray);
            transition: background-color 0.2s;
        }

        .nav-item:hover {
            background-color: var(--gmail-hover);
        }

        .nav-item.active {
            background-color: #d3e3fd;
            color: var(--gmail-blue);
            font-weight: 600;
        }

        .nav-item.active .nav-icon {
            color: var(--gmail-blue);
        }

        .nav-icon {
            width: 20px;
            height: 20px;
            color: var(--gmail-dark-gray);
            margin-right: 18px;
        }

        .sidebar-label {
            padding: 6px 0 6px 32px;
            font-size: 14px;
            font-weight: 500;
            color: var(--gmail-dark-gray);
        }

        .sidebar-footer {
            padding: 16px 0 0 24px;
            color: var(--gmail-dark-gray);
            font-size: 12px;
        }

        /* Email List */
        .email-list {
            flex: 1;
            background-color: white;
            border-right: 1px solid var(--gmail-border);
            overflow-y: auto;
        }

        .email-toolbar {
            height: 48px;
            padding: 8px 16px;
            border-bottom: 1px solid var(--gmail-border);
        }

        .email-checkbox {
            margin-right: 16px;
        }

        .toolbar-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            color: var(--gmail-dark-gray);
            transition: background-color 0.2s;
        }

        .toolbar-btn:hover {
            background-color: var(--gmail-hover);
        }

        .email-item {
            border-bottom: 1px solid var(--gmail-border);
            padding: 12px 16px;
            cursor: pointer;
            transition: background-color 0.2s, box-shadow 0.2s;
        }

        .email-item:hover {
            box-shadow: 0 1px 2px 0 var(--gmail-shadow);
            background-color: var(--gmail-hover);
        }

        .email-item.unread {
            background-color: #f2f6fc;
            font-weight: 600;
        }

        .email-item.unread .email-sender,
        .email-item.unread .email-subject {
            font-weight: 600;
        }

        .email-item.unread .email-time {
            font-weight: 600;
        }

        .email-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #e6e6e6;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 500;
            color: white;
            font-size: 16px;
            margin-right: 16px;
        }

        .email-sender {
            font-size: 14px;
            font-weight: 400;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
        }

        .email-subject {
            font-size: 14px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .email-preview {
            font-size: 14px;
            color: var(--gmail-dark-gray);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .email-time {
            font-size: 12px;
            color: var(--gmail-dark-gray);
            white-space: nowrap;
        }

        .email-star {
            color: #d1d1d1;
            transition: color 0.2s;
            margin-left: 16px;
        }

        .email-star.starred {
            color: #f7cb4d;
        }

        .pagination {
            height: 48px;
            border-top: 1px solid var(--gmail-border);
            color: var(--gmail-dark-gray);
            font-size: 14px;
        }

        /* Right Panel */
        .right-panel {
            width: 360px;
            background-color: white;
            border-left: 1px solid var(--gmail-border);
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .right-panel-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--gmail-border);
            font-size: 16px;
            font-weight: 500;
        }

        .right-panel-content {
            padding: 24px;
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: var(--gmail-dark-gray);
            text-align: center;
        }

        .right-panel-icon {
            font-size: 48px;
            color: #dadce0;
            margin-bottom: 16px;
        }

        /* Mobile view */
        @media (max-width: 992px) {
            .sidebar {
                position: fixed;
                left: -256px;
                z-index: 100;
                height: calc(100vh - 64px);
                top: 64px;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .right-panel {
                position: fixed;
                right: -360px;
                top: 64px;
                height: calc(100vh - 64px);
                z-index: 100;
            }
            
            .right-panel.active {
                right: 0;
            }
            
            .mobile-menu-btn {
                display: block !important;
            }
        }

        @media (max-width: 768px) {
            .search-bar {
                display: none;
            }
            
            .mobile-search-btn {
                display: block !important;
            }
            
            .email-sender {
                max-width: 120px;
            }
        }

        .mobile-menu-btn, .mobile-search-btn {
            display: none;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.5);
            z-index: 99;
            display: none;
        }
    </style>
</head>
<body>
    <!-- Top App Bar -->
    <header class="top-app-bar sticky-top d-flex align-items-center">
        <div class="container-fluid d-flex align-items-center">
            <div class="d-flex align-items-center me-3">
                <button class="btn mobile-menu-btn me-2 p-1 top-action-btn">
                    <i class="bi bi-list fs-5"></i>
                </button>
                <div class="d-flex align-items-center">
                    <div class="gmail-logo me-2"></div>
                    <span class="gmail-brand">Gmail</span>
                </div>
            </div>
            
            <div class="search-bar d-flex align-items-center flex-grow-1 mx-3">
                <i class="bi bi-search me-2 text-secondary"></i>
                <input type="text" placeholder="Search in emails">
                <i class="bi bi-tune ms-auto text-secondary"></i>
            </div>
            
            <div class="d-flex align-items-center">
                <button class="btn mobile-search-btn me-2 p-1 top-action-btn">
                    <i class="bi bi-search fs-5"></i>
                </button>
                <button class="btn p-1 top-action-btn me-2">
                    <i class="bi bi-question-circle fs-5"></i>
                </button>
                <button class="btn p-1 top-action-btn me-2">
                    <i class="bi bi-gear fs-5"></i>
                </button>
                <button class="btn p-1 top-action-btn me-2">
                    <i class="bi bi-grid-3x3-gap fs-5"></i>
                </button>
                <div class="user-avatar rounded-circle bg-primary d-flex align-items-center justify-content-center text-white fw-bold" style="width: 32px; height: 32px;">U</div>
            </div>
        </div>
    </header>
    
    <div class="overlay"></div>
    
    <!-- Main Content -->
    <div class="main-container d-flex">
        <!-- Sidebar -->
        <aside class="sidebar">
            <button class="btn btn-primary d-flex align-items-center w-100 compose-btn">
                <i class="bi bi-pencil-square fs-5 me-3"></i>
                <span>Compose</span>
            </button>
            
            <div class="nav flex-column mt-2">
                <a href="#" class="nav-item d-flex align-items-center active">
                    <i class="bi bi-inbox-fill nav-icon"></i>
                    <span>Inbox</span>
                    <span class="badge bg-danger rounded-pill ms-auto me-2">24</span>
                </a>
                <a href="#" class="nav-item d-flex align-items-center">
                    <i class="bi bi-star-fill nav-icon"></i>
                    <span>Starred</span>
                </a>
                <a href="#" class="nav-item d-flex align-items-center">
                    <i class="bi bi-clock-fill nav-icon"></i>
                    <span>Snoozed</span>
                </a>
                <a href="#" class="nav-item d-flex align-items-center">
                    <i class="bi bi-send-fill nav-icon"></i>
                    <span>Sent</span>
                </a>
                <a href="#" class="nav-item d-flex align-items-center">
                    <i class="bi bi-file-earmark-fill nav-icon"></i>
                    <span>Drafts</span>
                    <span class="badge bg-primary rounded-pill ms-auto me-2">3</span>
                </a>
                <a href="#" class="nav-item d-flex align-items-center">
                    <i class="bi bi-trash-fill nav-icon"></i>
                    <span>Trash</span>
                </a>
            </div>
            
            <div class="sidebar-label mt-4">LABELS</div>
            
            <div class="nav flex-column mt-1">
                <a href="#" class="nav-item d-flex align-items-center">
                    <i class="bi bi-bookmark-fill nav-icon" style="color: #0b57d0;"></i>
                    <span>Personal</span>
                </a>
                <a href="#" class="nav-item d-flex align-items-center">
                    <i class="bi bi-bookmark-fill nav-icon" style="color: #e37400;"></i>
                    <span>Work</span>
                </a>
                <a href="#" class="nav-item d-flex align-items-center">
                    <i class="bi bi-bookmark-fill nav-icon" style="color: #1e8e3e;"></i>
                    <span>Travel</span>
                </a>
            </div>
            
            <div class="sidebar-footer">
                <div class="d-flex align-items-center mb-2">
                    <i class="bi bi-google me-2"></i>
                    <span>Meet</span>
                </div>
                <div class="d-flex align-items-center">
                    <i class="bi bi-camera-video me-2"></i>
                    <span>Start a meeting</span>
                </div>
            </div>
        </aside>
        
        <!-- Email List -->
        <section class="email-list">
            <div class="email-toolbar d-flex align-items-center">
                <div class="form-check email-checkbox">
                    <input class="form-check-input" type="checkbox">
                </div>
                <button class="btn toolbar-btn">
                    <i class="bi bi-arrow-repeat"></i>
                </button>
                <button class="btn toolbar-btn">
                    <i class="bi bi-tag"></i>
                </button>
                <button class="btn toolbar-btn">
                    <i class="bi bi-person-x"></i>
                </button>
                <div class="d-flex ms-auto">
                    <button class="btn toolbar-btn">
                        <i class="bi bi-archive"></i>
                    </button>
                    <button class="btn toolbar-btn">
                        <i class="bi bi-trash"></i>
                    </button>
                    <button class="btn toolbar-btn">
                        <i class="bi bi-envelope"></i>
                    </button>
                    <button class="btn toolbar-btn">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                </div>
            </div>
            
            <div class="email-list-content">
                <div class="email-item d-flex align-items-center unread">
                    <div class="form-check email-checkbox">
                        <input class="form-check-input" type="checkbox">
                    </div>
                    <div class="email-star">
                        <i class="bi bi-star"></i>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="email-avatar bg-primary me-3">J</div>
                        <div style="min-width: 0; flex: 1;">
                            <div class="d-flex justify-content-between">
                                <div class="email-sender">John Smith</div>
                                <div class="email-time">10:42 AM</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="email-subject">Project Update - Q3 Review</div>
                                <div class="email-attachment">
                                    <i class="bi bi-paperclip"></i>
                                </div>
                            </div>
                            <div class="email-preview">Hi team, please find attached the Q3 project review document for your feedback. We need to finalize this by Friday...</div>
                        </div>
                    </div>
                </div>
                
                <div class="email-item d-flex align-items-center unread">
                    <div class="form-check email-checkbox">
                        <input class="form-check-input" type="checkbox">
                    </div>
                    <div class="email-star starred">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="email-avatar bg-success me-3">A</div>
                        <div style="min-width: 0; flex: 1;">
                            <div class="d-flex justify-content-between">
                                <div class="email-sender">Amazon Web Services</div>
                                <div class="email-time">9:15 AM</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="email-subject">Your AWS Bill - October 2023</div>
                                <div class="email-attachment">
                                    <i class="bi bi-paperclip"></i>
                                </div>
                            </div>
                            <div class="email-preview">Your AWS invoice for October 2023 is now available. The total amount due is $1,245.67. Payment is due by November 15...</div>
                        </div>
                    </div>
                </div>
                
                <div class="email-item d-flex align-items-center">
                    <div class="form-check email-checkbox">
                        <input class="form-check-input" type="checkbox">
                    </div>
                    <div class="email-star">
                        <i class="bi bi-star"></i>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="email-avatar bg-warning me-3">S</div>
                        <div style="min-width: 0; flex: 1;">
                            <div class="d-flex justify-content-between">
                                <div class="email-sender">Sarah Johnson</div>
                                <div class="email-time">Yesterday</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="email-subject">Lunch next week?</div>
                                <div class="email-attachment"></div>
                            </div>
                            <div class="email-preview">Hey, are you free for lunch next Tuesday? I wanted to discuss the marketing campaign...</div>
                        </div>
                    </div>
                </div>
                
                <div class="email-item d-flex align-items-center">
                    <div class="form-check email-checkbox">
                        <input class="form-check-input" type="checkbox">
                    </div>
                    <div class="email-star">
                        <i class="bi bi-star"></i>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="email-avatar bg-danger me-3">T</div>
                        <div style="min-width: 0; flex: 1;">
                            <div class="d-flex justify-content-between">
                                <div class="email-sender">Twitter</div>
                                <div class="email-time">Oct 28</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="email-subject">New login to your account</div>
                                <div class="email-attachment"></div>
                            </div>
                            <div class="email-preview">We noticed a new login to your Twitter account from a Chrome browser on Windows...</div>
                        </div>
                    </div>
                </div>
                
                <div class="email-item d-flex align-items-center">
                    <div class="form-check email-checkbox">
                        <input class="form-check-input" type="checkbox">
                    </div>
                    <div class="email-star">
                        <i class="bi bi-star"></i>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="email-avatar bg-info me-3">M</div>
                        <div style="min-width: 0; flex: 1;">
                            <div class="d-flex justify-content-between">
                                <div class="email-sender">Microsoft Office</div>
                                <div class="email-time">Oct 27</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="email-subject">Your subscription is expiring soon</div>
                                <div class="email-attachment"></div>
                            </div>
                            <div class="email-preview">Your Microsoft 365 subscription will expire in 14 days. Renew now to continue enjoying all the benefits...</div>
                        </div>
                    </div>
                </div>
                
                <div class="email-item d-flex align-items-center">
                    <div class="form-check email-checkbox">
                        <input class="form-check-input" type="checkbox">
                    </div>
                    <div class="email-star starred">
                        <i class="bi bi-star-fill"></i>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="email-avatar bg-secondary me-3">N</div>
                        <div style="min-width: 0; flex: 1;">
                            <div class="d-flex justify-content-between">
                                <div class="email-sender">Netflix</div>
                                <div class="email-time">Oct 26</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="email-subject">New on Netflix this November</div>
                                <div class="email-attachment"></div>
                            </div>
                            <div class="email-preview">See what's coming soon to Netflix this November. New seasons of your favorite shows and exciting new movies...</div>
                        </div>
                    </div>
                </div>
                
                <div class="email-item d-flex align-items-center">
                    <div class="form-check email-checkbox">
                        <input class="form-check-input" type="checkbox">
                    </div>
                    <div class="email-star">
                        <i class="bi bi-star"></i>
                    </div>
                    <div class="d-flex align-items-center flex-grow-1">
                        <div class="email-avatar bg-success me-3">L</div>
                        <div style="min-width: 0; flex: 1;">
                            <div class="d-flex justify-content-between">
                                <div class="email-sender">LinkedIn</div>
                                <div class="email-time">Oct 25</div>
                            </div>
                            <div class="d-flex justify-content-between">
                                <div class="email-subject">You have 5 new connection requests</div>
                                <div class="email-attachment"></div>
                            </div>
                            <div class="email-preview">Expand your professional network by accepting these connection requests from people in your industry...</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="pagination d-flex align-items-center justify-content-center">
                <span>1-50 of 1,284</span>
                <button class="btn toolbar-btn ms-3">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <button class="btn toolbar-btn ms-1">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </div>
        </section>
        
        <!-- Right Panel -->
        <aside class="right-panel">
            <div class="right-panel-header d-flex align-items-center">
                <span>Google Chat</span>
                <button class="btn toolbar-btn ms-auto">
                    <i class="bi bi-three-dots"></i>
                </button>
            </div>
            <div class="right-panel-content">
                <div class="right-panel-icon">
                    <i class="bi bi-chat-left-text"></i>
                </div>
                <h5>No conversations</h5>
                <p class="mt-2">Start a conversation with your contacts or find people to chat with.</p>
                <button class="btn btn-outline-primary mt-3">Start chat</button>
            </div>
        </aside>
    </div>

    <!-- Floating Compose Button (Mobile) -->
    <button class="btn btn-primary rounded-circle position-fixed d-md-none" style="bottom: 24px; right: 24px; width: 56px; height: 56px; box-shadow: 0 1px 3px rgba(0,0,0,0.2);">
        <i class="bi bi-pencil fs-5"></i>
    </button>

    <script>
        // Mobile menu toggle
        document.querySelector('.mobile-menu-btn').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
            document.querySelector('.overlay').style.display = 'block';
        });

        // Overlay click to close sidebars
        document.querySelector('.overlay').addEventListener('click', function() {
            document.querySelector('.sidebar').classList.remove('active');
            document.querySelector('.right-panel').classList.remove('active');
            this.style.display = 'none';
        });

        // Star toggle functionality
        document.querySelectorAll('.email-star').forEach(star => {
            star.addEventListener('click', function(e) {
                e.stopPropagation();
                this.classList.toggle('starred');
                const icon = this.querySelector('i');
                if (icon.classList.contains('bi-star')) {
                    icon.classList.remove('bi-star');
                    icon.classList.add('bi-star-fill');
                } else {
                    icon.classList.remove('bi-star-fill');
                    icon.classList.add('bi-star');
                }
            });
        });

        // Email item click
        document.querySelectorAll('.email-item').forEach(item => {
            item.addEventListener('click', function() {
                // In a real app, this would open the email
                // For this demo, we'll just toggle the unread state
                this.classList.toggle('unread');
            });
        });

        // Mobile search button
        document.querySelector('.mobile-search-btn').addEventListener('click', function() {
            document.querySelector('.search-bar').classList.toggle('d-none');
        });
    </script>
</body>
</html>