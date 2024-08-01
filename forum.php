<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Stories - ScamGuard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="login.css">
    <style>
    .card-title i {
        margin-right: 10px;
    }
    .rating i {
        cursor: pointer;
        color: #ccc;
    }
    .rating i.active {
        color: #f39c12;
    }
    .post-actions {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }
    .post-actions i {
        cursor: pointer;
        margin-right: 10px;
    }
    .post-actions .action-buttons {
        display: flex;
        align-items: center;
    }
    .publish-btn {
        background-color: #666; /* Changed to a lighter grey */
        color: #fff;
        border: none;
        padding: 5px 10px;
        margin-left: 10px; /* Adjusted to bring the button closer */
        cursor: pointer;
    }
    .publish-btn:hover {
        background-color: #888; /* Slightly darker grey for hover effect */
    }
</style>


</head>
<body>
    <?php include('header.php'); ?>

    <div class="container mt-5">
    <h1 class="teal-heading text-center">Community Stories</h1>
        <p class="text-center">Read real-life stories shared by our community members about their experiences with scams.</p>

        <?php if (isset($_SESSION['user_id'])): ?>
        <!-- Form to create a new post -->
        <div class="card mb-5">
            <div class="card-body">
                <h3 class="card-title"><i class="fas fa-pencil-alt"></i> Share Your Story</h3>
                <form id="storyForm" action="forum_process.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="rating">Level of Awareness</label>
                        <div class="rating">
                            <i class="fas fa-star" data-value="1"></i>
                            <i class="fas fa-star" data-value="2"></i>
                            <i class="fas fa-star" data-value="3"></i>
                            <i class="fas fa-star" data-value="4"></i>
                            <i class="fas fa-star" data-value="5"></i>
                        </div>
                        <input type="hidden" name="rating" id="rating" value="0">
                    </div>
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Share your scam story</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Add images</label>
                        <input type="file" class="form-control-file" id="image" name="image">
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- Display posts and comments -->
        <div class="posts" id="posts">
            <!-- Posts will be loaded here dynamically -->
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer mt-auto">
        <div class="container">
            <div class="footer-content">
                <div class="footer-column">
                    <h4>SCAMGUARD</h4>
                    <p>
                        <i class="fas fa-map-marker-alt"></i> Nilai, Malaysia<br>
                        <i class="fas fa-envelope"></i> scamguard2323@example.com
                    </p>
                    <p>Follow our social media</p>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="footer-column quick-links">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="register.php">Register</a></li>
                        <li><a href="contact.php">Contact Us</a></li>
                        <li><a href="scamCallAnalyzer.php">Scam Call Analyzer</a></li>
                        <li><a href="emailPhishingChecker.php">Email Phishing Checker</a></li>
                    </ul>
                </div>
            </div>
            <p class="text-center mt-4">© 2022 Inti International University - All Rights Reserved</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        // Handle star rating
        document.querySelectorAll('.rating i').forEach(star => {
            star.addEventListener('click', function() {
                let rating = this.getAttribute('data-value');
                document.getElementById('rating').value = rating;
                document.querySelectorAll('.rating i').forEach(star => {
                    star.classList.remove('active');
                });
                for (let i = 0; i < rating; i++) {
                    document.querySelectorAll('.rating i')[i].classList.add('active');
                }
            });
        });

        // Handle form submission
        document.getElementById('storyForm')?.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(this);

            console.log('Submitting form', formData);

            fetch('forum_process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(text => {
                console.log('Raw response', text);
                try {
                    const data = JSON.parse(text);
                    console.log('Parsed JSON response', data);

                    if (data.success) {
                        loadPosts();
                        this.reset();
                        document.getElementById('rating').value = 0;
                        document.querySelectorAll('.rating i').forEach(star => {
                            star.classList.remove('active');
                        });
                    } else {
                        alert('Error posting story: ' + (data.error || 'Unknown error.'));
                    }
                } catch (e) {
                    console.error('Error parsing JSON', e);
                    alert('An error occurred while processing your request.');
                }
            })
            .catch(error => {
                console.error('Fetch error', error);
                alert('An error occurred while posting your story.');
            });
        });

        // Handle comment submission
        document.addEventListener('submit', function(event) {
            if (event.target.matches('form[action="comment_process.php"]')) {
                event.preventDefault();
                const formData = new FormData(event.target);

                console.log('Submitting comment', formData);

                fetch('comment_process.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(text => {
                    console.log('Raw response', text);
                    try {
                        const data = JSON.parse(text);
                        console.log('Parsed JSON response', data);

                        if (data.success) {
                            loadPosts();
                        } else {
                            alert('Error posting comment: ' + (data.error || 'Unknown error.'));
                        }
                    } catch (e) {
                        console.error('Error parsing JSON', e);
                        alert('An error occurred while processing your request.');
                    }
                })
                .catch(error => {
                    console.error('Fetch error', error);
                    alert('An error occurred while posting your comment.');
                });
            }
        });

        function loadPosts() {
            fetch('load_posts.php')
            .then(response => response.json())
            .then(data => {
                const postsDiv = document.getElementById('posts');
                postsDiv.innerHTML = '';

                data.forEach(post => {
                    const postCard = document.createElement('div');
                    postCard.classList.add('card', 'mb-3');

                    postCard.innerHTML = `
                        <div class="card-body">
                            <h5 class="card-title">${post.title}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">By ${post.username} on ${post.date}</h6>
                            <p class="card-text">${post.content}</p>
                            ${post.image ? `<img src="${post.image}" alt="Post image" class="img-fluid mb-3">` : ''}
                            <div class="post-actions">
                                <div class="action-buttons">
                                    <i class="far fa-thumbs-up" onclick="handleUpvote(${post.id})"></i> <span id="like-count-${post.id}">${post.likes || 0}</span>
                                    <i class="far fa-comment"></i> <span>${post.comments.length}</span>
                                </div>
                                <?php if (!isset($_SESSION['user_id'])): ?>
                                <button class="publish-btn" onclick="redirectToLogin()">Publish Your Own Story</button>
                                <?php endif; ?>
                            </div>
                            <hr>
                            <h6>Comments</h6>
                            ${post.comments.map(comment => `
                                <p><strong>${comment.username}:</strong> ${comment.content} <em>(${comment.date})</em></p>
                            `).join('')}
                            <form action="comment_process.php" method="post" class="mt-3" onsubmit="return handleCommentSubmit(event, ${post.id})">
                                <div class="form-group">
                                    <label for="comment">Add a Comment</label>
                                    <textarea class="form-control" id="comment-${post.id}" name="content" rows="2" required></textarea>
                                </div>
                                <input type="hidden" name="post_id" value="${post.id}">
                                <button type="submit" class="btn btn-secondary">Comment</button>
                            </form>
                        </div>
                    `;

                    postsDiv.prepend(postCard);
                });
            });
        }
// Function to handle upvote
function handleUpvote(postId) {
    fetch('like_post.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ post_id: postId })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            const likeCountSpan = document.getElementById(`like-count-${postId}`);
            let currentLikes = parseInt(likeCountSpan.textContent, 10);
            likeCountSpan.textContent = data.action === 'liked' ? currentLikes + 1 : currentLikes - 1;
        } else {
            alert('Error: ' + data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}


        // Function to handle comment submission for non-logged-in users
        function handleCommentSubmit(event, postId) {
            if (!<?php echo isset($_SESSION['user_id']) ? 'true' : 'false'; ?>) {
                event.preventDefault();
                alert('Please login/register to comment.');
                window.location.href = 'register.php';
                return false;
            }
            return true;
        }

        // Function to redirect to login page
        function redirectToLogin() {
            alert('Please login/register to continue.');
            window.location.href = 'register.php';
        }

        // Load posts on page load
        loadPosts();
    </script>
</body>
</html>
