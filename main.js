document.addEventListener('DOMContentLoaded', function() {
    console.log("DOM fully loaded and parsed");

   // Scam Call Analyzer
const form = document.querySelector('#scamCallForm');
const resultDiv = document.querySelector('#analysisResult');
const resultText = document.querySelector('#resultText');
const popup = document.querySelector('#popup');
const overlay = document.querySelector('#overlay');
const popupMessage = document.querySelector('#popupMessage');
const popupImage = document.querySelector('#popupImage');

// Debugging: Ensure all elements are correctly selected
console.log('form:', form);
console.log('resultDiv:', resultDiv);
console.log('resultText:', resultText);
console.log('popup:', popup);
console.log('overlay:', overlay);

if (form && resultDiv && resultText && popup && overlay) {
    form.addEventListener('submit', function (e) {
        e.preventDefault();
        console.log("Form submitted");

        var callDuration = document.querySelector('#callDuration').value;
        var commonWords = document.querySelector('#commonWords').value;
        var callType = document.querySelector('#callType').value;
        var personalInfoRequest = document.querySelector('#personalInfoRequest').value;
        var emotionTactics = document.querySelector('#emotionTactics').value;

        console.log("Form data: ", {
            callDuration: callDuration,
            commonWords: commonWords,
            callType: callType,
            personalInfoRequest: personalInfoRequest,
            emotionTactics: emotionTactics
        });

        fetch('process_call.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                callDuration: callDuration,
                commonWords: commonWords,
                callType: callType,
                personalInfoRequest: personalInfoRequest,
                emotionTactics: emotionTactics
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data && data.result) {
                let resultMessage = data.result;
                if (resultMessage.includes("most likely a fraud")) {
                    popupImage.src = 'img/danger.jpg';
                    popupImage.alt = 'Danger Sign';
                } else {
                    popupImage.src = 'img/nodanger.jpg';
                    popupImage.alt = 'No Danger Sign';
                }
                popupMessage.textContent = resultMessage;
            } else {
                popupMessage.textContent = 'Unexpected error.';
            }
            popup.style.display = 'block';
            overlay.style.display = 'block';
        })
        .catch(error => {
            popupMessage.textContent = 'Error processing the request: ' + error;
            popup.style.display = 'block';
            overlay.style.display = 'block';
        });
    });
} else {
    console.error('Required elements not found in the DOM.');
}

window.closePopup = function() {
    popup.style.display = 'none';
    overlay.style.display = 'none';
    resetForm();
}

function resetForm() {
    if (form) {
        console.log('Resetting form in resetForm');
        form.reset();
        // Additional check to ensure all input fields are reset
        const inputs = form.querySelectorAll('input, select');
        inputs.forEach(input => {
            input.value = '';
        });
    } else {
        console.error('Form not found for reset in resetForm');
    }
}




 // Phishing Email Checker
const phishingForm = document.querySelector('#phishingForm');
const phishingPopup = document.querySelector('#popup');
const phishingOverlay = document.querySelector('#overlay');
const phishingPopupMessage = document.querySelector('#popupMessage');
const phishingPopupImage = document.querySelector('#popupImage');

if (phishingForm && phishingPopup && phishingOverlay && phishingPopupMessage && phishingPopupImage) {
    phishingForm.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log("Phishing form submitted");

        var emailText = document.querySelector('#emailText').value;

        console.log("Email text: ", emailText);

        const requestBody = JSON.stringify({ emailText: emailText });
        console.log("Request body: ", requestBody);

        fetch('process_email.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: requestBody
        })
        .then(response => response.json())
        .then(data => {
            console.log("Response received: ", data);
            if (data && data.result) {
                let resultMessage = data.result === "spam" ? 
                    "This email is most likely spam." : 
                    "This email is most likely not spam.";
                let imagePath = data.result === "spam" ? 
                    'img/danger.jpg' : 
                    'img/nodanger.jpg';
                phishingPopupImage.src = imagePath;
                phishingPopupMessage.textContent = resultMessage;
            } else if (data && data.error) {
                phishingPopupMessage.textContent = 'Error: ' + data.error;
            } else {
                phishingPopupMessage.textContent = 'Unexpected error.';
            }
            phishingPopup.style.display = 'block';
            phishingOverlay.style.display = 'block';
        })
        .catch(error => {
            console.error('Error: ', error);
            phishingPopupMessage.textContent = 'Error processing the request: ' + error;
            phishingPopup.style.display = 'block';
            phishingOverlay.style.display = 'block';
        });
    });
} else {
    console.error('Required elements not found in the DOM.');
}

window.closePopup = function() {
    phishingPopup.style.display = 'none';
    phishingOverlay.style.display = 'none';
    document.querySelector('#emailText').value = ''; // Reset the form
}



    // Ensure other functionalities are properly initialized
    // Smooth scrolling for internal links
    const links = document.querySelectorAll('a[href^="#"]');
    for (const link of links) {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            window.scrollTo({
                top: targetElement.offsetTop,
                behavior: 'smooth'
            });
        });
    }

    // Scroll animation on page load
    const elements = document.querySelectorAll('.animate-on-scroll');

    if (elements.length) {
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('animate__fadeInUp');
                }
            });
        });

        elements.forEach(element => {
            observer.observe(element);
        });
    }

    // Add event listeners to buttons
    const buttons = document.querySelectorAll('.btn.circle-btn');
    buttons.forEach(button => {
        button.addEventListener('click', function() {
            alert('Button clicked!');
        });
    });

    // Form validation
    const searchForm = document.querySelector('form');
    if (searchForm) {
        searchForm.addEventListener('submit', function(event) {
            const searchInput = document.querySelector('input[name="search"]');
            if (searchInput && searchInput.value.trim() === '') {
                event.preventDefault();
                alert('Please enter a search term.');
            }
        });
    }

    // Scroll to top button functionality
    const scrollToTopBtn = document.createElement('button');
    scrollToTopBtn.innerText = '↑';
    scrollToTopBtn.classList.add('scroll-to-top');
    document.body.appendChild(scrollToTopBtn);

    scrollToTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

    window.addEventListener('scroll', function() {
        if (window.pageYOffset > 300) {
            scrollToTopBtn.style.display = 'block';
        } else {
            scrollToTopBtn.style.display = 'none';
        }
    });

    // Smooth scrolling for all anchor links
    const anchorLinks = document.querySelectorAll('a[href^="#"]');
    anchorLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    //Quiz functionality
    
      // Variables and elements
    const quizButtons = document.querySelectorAll('.quiz-button');
    const quizQuestionsContainer1 = document.getElementById('quizQuestions1');
    const quizQuestionsContainer2 = document.getElementById('quizQuestions2');
    const quizQuestionsContainer3 = document.getElementById('quizQuestions3');
    const quizContainer = document.querySelector('.quiz-container');
    const quizSection = document.getElementById('quiz-section');
    const tabs = document.querySelector('.tabs');
    const timerElements = document.querySelectorAll('.timer');
    let currentPage = 1;
    let totalPages = 3;
    let timeRemaining;
    let timerInterval;

    function showPage(pageNumber) {
        for (let i = 1; i <= totalPages; i++) {
            document.getElementById(`page-${i}`).style.display = (i === pageNumber) ? 'block' : 'none';
        }
    }

    function startTimer(duration) {
        timeRemaining = duration;
        timerInterval = setInterval(function() {
            if (timeRemaining <= 0) {
                clearInterval(timerInterval);
                alert('Time is up!');
                // Handle timeout logic here
                return;
            }
            timeRemaining--;
            const minutes = Math.floor(timeRemaining / 60);
            const seconds = timeRemaining % 60;
            const timeString = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            timerElements.forEach(timerElement => timerElement.innerHTML = timeString);
        }, 1000);
    }

    function fetchAndDisplayQuestions(difficulty) {
        console.log("Fetching questions for difficulty:", difficulty);
        fetch(`fetch_questions.php?difficulty=${difficulty}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(questions => {
                console.log('Fetched questions:', questions); // Debug statement
                let quizHtml1 = '', quizHtml2 = '', quizHtml3 = '';
                questions.forEach((q, index) => {
                    const questionHtml = `
                        <div class="form-group">
                            <label>${index + 1}. ${q.question}</label>
                            ${['a', 'b', 'c', 'd'].map(opt => `
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="answer[${q.quiz_id}]" value="${opt}" required>
                                    <label class="form-check-label">${q[`option_${opt}`]}</label>
                                </div>
                            `).join('')}
                        </div>
                    `;
                    if (index < 3) {
                        quizHtml1 += questionHtml;
                    } else if (index < 6) {
                        quizHtml2 += questionHtml;
                    } else {
                        quizHtml3 += questionHtml;
                    }
                });
                quizQuestionsContainer1.innerHTML = quizHtml1;
                quizQuestionsContainer2.innerHTML = quizHtml2;
                quizQuestionsContainer3.innerHTML = quizHtml3;
            })
            .catch(error => console.error('Error fetching questions:', error));
    }

    function updateQuizLockState() {
        fetch('check_quiz_progress.php')
            .then(response => response.json())
            .then(data => {
                console.log('Fetched user total stars:', data.total_stars); // Debug statement
                const totalStars = data.total_stars;
                quizButtons.forEach(button => {
                    const difficulty = button.dataset.difficulty;
                    const requiredStars = difficulty === 'medium' ? 24 : (difficulty === 'hard' ? 48 : 0);

                    console.log(`Button difficulty: ${difficulty}, Required Stars: ${requiredStars}, User Stars: ${totalStars}`); // Debug statement

                    if (totalStars >= requiredStars) {
                        button.classList.remove('locked');
                        const lockIcon = button.querySelector('.lock-icon');
                        if (lockIcon) {
                            lockIcon.style.display = 'none';
                        }
                        // Ensure the button is not disabled
                        button.querySelector('button').removeAttribute('disabled');
                    } else {
                        button.classList.add('locked');
                        const lockIcon = button.querySelector('.lock-icon');
                        if (lockIcon) {
                            lockIcon.style.display = 'block';
                        }
                        // Ensure the button is disabled
                        button.querySelector('button').setAttribute('disabled', 'disabled');
                    }
                });

                document.querySelectorAll('.tab-link').forEach(tab => {
                    const tabDifficulty = tab.dataset.difficulty;
                    const requiredStars = tabDifficulty === 'medium' ? 24 : (tabDifficulty === 'hard' ? 48 : 0);

                    console.log(`Tab difficulty: ${tabDifficulty}, Required Stars: ${requiredStars}, User Stars: ${totalStars}`); // Debug statement

                    if (totalStars >= requiredStars) {
                        tab.classList.remove('locked');
                        tab.removeAttribute('disabled');
                    } else {
                        tab.classList.add('locked');
                        tab.setAttribute('disabled', 'disabled');
                    }
                });
            })
            .catch(error => console.error('Error fetching quiz progress:', error));
    }

    // Event listeners for quiz buttons
    quizButtons.forEach(button => {
        button.addEventListener('click', function() {
            const difficulty = this.dataset.difficulty;
            if (this.classList.contains('locked')) {
                alert('This quiz is locked. Please complete the previous quizzes to unlock.');
                return;
            }
            fetchAndDisplayQuestions(difficulty);

            // Set timer duration based on difficulty
            let duration;
            switch (difficulty) {
                case 'easy':
                    duration = 600; // 10 minutes
                    break;
                case 'medium':
                    duration = 300; // 5 minutes
                    break;
                case 'hard':
                    duration = 180; // 3 minutes
                    break;
            }

            // Add the class to move the quiz cards to the left
            quizContainer.classList.add('quiz-hidden');

            // Show quiz section after the animation
            setTimeout(() => {
                quizSection.style.display = 'block';
                tabs.style.display = 'flex';
                quizContainer.style.display = 'none';
                
                // Highlight the current tab
                document.querySelectorAll('.tab-link').forEach(tab => {
                    if (tab.dataset.difficulty === difficulty) {
                        tab.classList.add('active');
                    } else {
                        tab.classList.remove('active');
                    }
                });

                // Update tab lock state
                updateQuizLockState();

                // Start the timer
                startTimer(duration);

                // Show the first page of questions
                showPage(1);
            }, 500); // Adjust the timeout to match the CSS transition duration
        });
    });

    // Event listeners for navigation buttons
    document.getElementById('next-1').addEventListener('click', function() {
        currentPage++;
        showPage(currentPage);
    });

    document.getElementById('prev-2').addEventListener('click', function() {
        currentPage--;
        showPage(currentPage);
    });

    document.getElementById('next-2').addEventListener('click', function() {
        currentPage++;
        showPage(currentPage);
    });

    document.getElementById('prev-3').addEventListener('click', function() {
        currentPage--;
        showPage(currentPage);
    });

    // Form submission event listener
    const quizForm = document.getElementById('quizForm');
    if (quizForm) {
        quizForm.addEventListener('submit', function(event) {
            event.preventDefault();
            clearInterval(timerInterval);
            const formData = new FormData(quizForm);
            const difficulty = document.querySelector('.tab-link.active').dataset.difficulty;
            formData.append('difficulty', difficulty); // Append difficulty to form data

            // Debug: Log form data
            for (const [key, value] of formData.entries()) {
                console.log(`FormData - ${key}: ${value}`);
            }

            fetch('quizz_process.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                console.log('Response received from server: ', response); // Added for debugging
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.text(); // Parse as text to catch potential HTML error responses
            })
            .then(text => {
                console.log('Raw text received from server: ', text); // Added for debugging
                let data;
                try {
                    data = JSON.parse(text);
                } catch (e) {
                    throw new Error('Failed to parse JSON response: ' + text);
                }
                console.log('Parsed data received from server: ', data); // Added for debugging

                if (data.success) {
                    window.location.href = `quiz_results.php?difficulty=${difficulty}`;
                } else {
                    alert('There was an error processing your quiz. Please try again.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('There was an error submitting your quiz. Please try again later.');
            });
        });
    }

    // Initial fetch of questions if a difficulty is pre-selected
    const difficultySelect = document.getElementById('difficulty');
    if (difficultySelect && difficultySelect.value) {
        fetchAndDisplayQuestions(difficultySelect.value);
    }

    // Check and update quiz lock state on page load
    updateQuizLockState();
});