 <!--
    Author: Damian Loh Yi Feng
    Date: 2026-1-10
    Description: Create Reward Page for Admins
-->
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/session.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Create Reward | GoGreen@APU</title>

    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/hero.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/my_events/information.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/checkbox_switch.css">

    <style>
        .header-actions img {
            width: 20px !important;
            height: 20px !important;
            object-fit: contain;
            margin-right: 8px;
        }

        .header-actions button,
        .header-actions a {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            border: none;
            cursor: pointer;
            transition: 0.2s;
            height: 45px;
            box-sizing: border-box;
            font-size: 1rem;
            font-family: inherit;
        }
    </style>
</head>

<body>
    <?php 
    $page_name = 'create_reward'; 
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php'); 
    ?>

    <main>
        <section class="page-content" style="margin-top: 40px;">

            <form action="/GoGreen-APU/actions/admin/reward/save_reward.php" method="post" enctype="multipart/form-data" id="create-reward-form">

                <div class="page-header">
                    <h2>New Reward</h2>
                    <div class="header-actions">
                        <a href="index.php" class="btn-discard">
                            <img src="/GoGreen-APU/assets/icons/x.circle.fill.svg" alt="X">
                            <span>Cancel</span>
                        </a>

                        <button type="submit" class="btn-save" value="Save Reward">
                            <img src="/GoGreen-APU/assets/icons/plus.app.fill.svg" alt="Create">
                            <span>Create Reward</span>
                        </button>
                    </div>
                </div>

                <div class="form-part">
                    <div class="form-part-header">
                        <span><img src="/GoGreen-APU/assets/icons/info.circle.svg" alt=""></span>
                        <h3>Basic Information</h3>
                    </div>

                    <div class="form-part-content">
                        <div class="form-field">
                            <label for="title">Reward Title</label>
                            <div class="txt-container glass-effect-border">
                                <input type="text" name="title" id="title" placeholder="Example: Eco-friendly Water Bottle" required>
                                <button type="button" class="clear-btn" data-target="title">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                </button>
                            </div>
                        </div>

                        <div class="form-field">
                            <label for="description">Description</label>
                            <div class="txt-container glass-effect-border">
                                <textarea name="description" id="description" rows="4" placeholder="Describe the item features" required></textarea>
                                <button type="button" class="clear-btn" data-target="description">
                                    <img src="/GoGreen-APU/assets/icons/xmark.svg" alt="Clear">
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-subpart">

                    <div class="form-subpart-container">
                        <div class="form-part-header">
                            <span><img src="/GoGreen-APU/assets/icons/dollarsign.circle.fill.svg" alt="Cost"></span>
                            <h3>Cost</h3>
                        </div>
                        <div class="form-part-content">
                            <div class="form-field">
                                <label for="cost">AP Coins Required</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="number" name="cost" id="cost" placeholder="e.g. 500" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-subpart-container">
                        <div class="form-part-header">
                            <span><img src="/GoGreen-APU/assets/icons/shippingbox.svg" alt="Stock"></span>
                            <h3>Inventory</h3>
                        </div>
                        <div class="form-part-content">
                            <div class="form-field">
                                <label for="quantity">Stock Quantity</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="number" name="quantity" id="quantity" placeholder="e.g. 50" min="0" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-subpart">

                    <div class="form-subpart-container">
                        <div class="form-part-header">
                            <span><img src="/GoGreen-APU/assets/icons/gearshape.fill.svg" alt="Config"></span>
                            <h3>Configuration</h3>
                        </div>
                        <div class="form-part-content">
                            <div class="form-field">
                                <label for="is_active">Set Active Immediately</label>
                                <div class="checkbox-switch">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" checked>
                                    <label for="is_active"></label>
                                </div>
                                <p style="font-size: 0.8rem; color: rgba(255,255,255,0.5); margin-top: 5px;">
                                    Enable to make this item visible to students immediately
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="form-subpart-container">
                        <div class="form-part-header">
                            <span>
                                <img src="/GoGreen-APU/assets/icons/navigation/rewards.svg"
                                    alt="Image"
                                    style="filter: brightness(0) invert(1);">
                            </span>
                            <h3>Reward Image</h3>
                        </div>
                        <div class="form-part-content">
                            <div class="form-field">
                                <label for="image">Upload Image</label>
                                <div class="txt-container glass-effect-border">
                                    <input type="file" name="image" id="image" accept="image/*" required style="padding: 10px;">
                                </div>
                                <p style="font-size: 0.8rem; color: rgba(255,255,255,0.5); margin-top: 5px;">
                                    Supported formats: JPG, PNG and WEBP
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </section>
    </main>

    <script>
        document.querySelectorAll('.clear-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                if (input) {
                    input.value = '';
                    input.focus();
                }
            });
        });
    </script>
</body>

</html>