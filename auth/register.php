<!-- 
Author: Chong Ray Han
Date: 2025-12-29
Description: Register Page with step form, backend: register_process.php
-->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Student Registration</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/auth/auth.css">
</head>

<body>

    <div class="middle">
        <h2>New Student Registration</h2>

        <div class="main_card">
            <form id="registrationForm" action="/GoGreen-APU/actions/register_process.php" method="POST"
                enctype="multipart/form-data">

                <div class="form-step step-active">
                    <div class="section-title">Step 1: Account Details</div>
                    <div class="form-field">
                        <label>First Name</label>
                        <div class="txt-container glass-effect-border">
                            <input type="text" name="first_name" required placeholder="e.g. Xiao Ming">
                        </div>
                    </div>
                    <div class="form-field">
                        <label>Last Name</label>
                        <div class="txt-container glass-effect-border">
                            <input type="text" name="last_name" required placeholder="e.g. Chong">
                        </div>
                    </div>
                    <div class="form-field">
                        <label>Profile Picture</label>
                        <div class="txt-container glass-effect-border">
                            <input type="file" name="avatar" accept="image/*" required>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn-next">Next</button>
                    </div>
                </div>

                <div class="form-step">
                    <div class="section-title">Step 2: Enter Credentials</div>
                    <div class="form-field">
                        <label>TP Number</label>
                        <div class="txt-container glass-effect-border">
                            <input type="text" name="apkey" required placeholder="TP052293">
                        </div>
                    </div>
                    <div class="form-field">
                        <label>Password</label>
                        <div class="txt-container glass-effect-border">
                            <input type="password" name="password" required placeholder="Enter password">
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn-prev">Previous</button>
                        <button type="button" class="btn-next">Next</button>
                    </div>
                </div>

                <div class="form-step">
                    <div class="section-title">Step 3: Personal Information</div>
                    <div class="form-field">
                        <label>Phone Number</label>
                        <div class="txt-container glass-effect-border">
                            <input type="text" name="phone_no" required placeholder="e.g. 012-3456789">
                        </div>
                    </div>
                    <div class="form-field">
                        <label>Date of Birth</label>
                        <div class="txt-container glass-effect-border">
                            <input type="date" name="dob" required>
                        </div>
                    </div>
                    <div class="form-field">
                        <label>Gender</label>
                        <div class="radio-group">
                            <input type="radio" name="gender" value="Male" id="male" required>
                            <label for="male">Male</label>
                            <input type="radio" name="gender" value="Female" id="female">
                            <label for="female">Female</label>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn-prev">Previous</button>
                        <button type="button" class="btn-next">Next</button>
                    </div>
                </div>

                <div class="form-step">
                    <div class="section-title">Step 4: Security Questions</div>

                    <div class="form-field">
                        <label>Security Question 1</label>
                        <div class="txt-container glass-effect-border">
                            <select name="security_quest1" id="security_quest1" required>
                                <option value="" disabled selected>Select a question</option>
                                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                <option value="What is your favorite colour?">What is your favorite colour?</option>
                                <option value="What is your first pet's name?">What is your first pet's name?</option>
                                <option value="What is your Hometown's name?">What is your Hometown's name?</option>
                                <option value="What was the name of your best friend in elementary school?">What was the name of your best friend in elementary school?</option>
                                <option value="Who was your childhood hero?">Who was your childhood hero?</option>
                                <option value="What was the model of your first car?">What was the model of your first car?</option>
                                <option value="Where did you fly for your first airplane trip?">Where did you fly for your first airplane trip?</option>
                            </select>
                        </div>
                        <div class="txt-container glass-effect-border" style="margin-top: 10px;">
                            <input type="text" name="security_ans1" placeholder="Answer" required>
                        </div>
                    </div>

                    <div class="form-field">
                        <label>Security Question 2</label>
                        <div class="txt-container glass-effect-border">
                            <select name="security_quest2" id="security_quest2" required>
                                <option value="" disabled selected>Select a question</option>
                                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                <option value="What is your favorite colour?">What is your favorite colour?</option>
                                <option value="What is your first pet's name?">What is your first pet's name?</option>
                                <option value="What is your Hometown's name?">What is your Hometown's name?</option>
                                <option value="What was the name of your best friend in elementary school?">What was the name of your best friend in elementary school?</option>
                                <option value="Who was your childhood hero?">Who was your childhood hero?</option>
                                <option value="What was the model of your first car?">What was the model of your first car?</option>
                                <option value="Where did you fly for your first airplane trip?">Where did you fly for your first airplane trip?</option>
                            </select>
                        </div>
                        <div class="txt-container glass-effect-border" style="margin-top: 10px;">
                            <input type="text" name="security_ans2" placeholder="Answer" required>
                        </div>
                    </div>

                    <div class="form-field">
                        <label>Security Question 3</label>
                        <div class="txt-container glass-effect-border">
                            <select name="security_quest3" id="security_quest3" required>
                                <option value="" disabled selected>Select a question</option>
                                <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                                <option value="What is your favorite colour?">What is your favorite colour?</option>
                                <option value="What is your first pet's name?">What is your first pet's name?</option>
                                <option value="What is your Hometown's name?">What is your Hometown's name?</option>
                                <option value="What was the name of your best friend in elementary school?">What was the name of your best friend in elementary school?</option>
                                <option value="Who was your childhood hero?">Who was your childhood hero?</option>
                                <option value="What was the model of your first car?">What was the model of your first car?</option>
                                <option value="Where did you fly for your first airplane trip?">Where did you fly for your first airplane trip?</option>
                            </select>
                        </div>
                        <div class="txt-container glass-effect-border" style="margin-top: 10px;">
                            <input type="text" name="security_ans3" placeholder="Answer" required>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn-prev">Previous</button>
                        <button type="button" class="btn-next">Next</button>
                    </div>
                </div>

                <div class="form-step">
                    <div class="section-title">Step 5: Student Details</div>
                    <div class="form-field">
                        <label>Course</label>
                        <div class="txt-container glass-effect-border">
                            <input type="text" name="course" required placeholder="e.g. Computer Science">
                        </div>
                    </div>
                    <div class="form-field">
                        <label>Graduation Year</label>
                        <div class="txt-container glass-effect-border">
                            <input type="number" name="graduation" min="2025" max="2040" required placeholder="e.g. 2027">
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn-prev">Previous</button>
                        <button type="submit" class="btn-submit" name="register_btn">Register Now</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        const steps = Array.from(document.querySelectorAll(".form-step"));
        const nextBtns = document.querySelectorAll(".btn-next");
        const prevBtns = document.querySelectorAll(".btn-prev");

        nextBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                changeStep("next");
            });
        });

        prevBtns.forEach((btn) => {
            btn.addEventListener("click", () => {
                changeStep("prev");
            });
        });

        function changeStep(btnType) {
            let index = 0;
            const active = document.querySelector(".step-active");
            index = steps.indexOf(active);

            const inputs = active.querySelectorAll("input");
            const allValid = Array.from(inputs).every(input => input.reportValidity());

            if (btnType === "next" && allValid) {
                if (index + 1 < steps.length) {
                    steps[index].classList.remove("step-active");
                    steps[index + 1].classList.add("step-active");
                }
            } else if (btnType === "prev") {
                if (index - 1 >= 0) {
                    steps[index].classList.remove("step-active");
                    steps[index - 1].classList.add("step-active");
                }
            }
        }
    </script>
</body>

</html>