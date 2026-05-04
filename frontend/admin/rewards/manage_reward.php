 <!--
    Author: Damian Loh Yi Feng
    Date: 2026-1-10
    Description: Manage Reward Page for Admins
-->
<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/session.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/db_conn.php');

$reward_id = 0;
if (isset($_GET['id'])) {
    $reward_id = intval($_GET['id']);
}

$reward_data = null;

if ($reward_id > 0) {
    $sql = "SELECT * FROM rewards WHERE id = $reward_id";
    $result = mysqli_query($conn, $sql);
    
    if ($result) {
        $reward_data = mysqli_fetch_assoc($result);
    }
}

if (!$reward_data) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/includes/head.php'); ?>
    <title>Edit Reward | GoGreen@APU</title>
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/organizer/sidebar.css">
    <link rel="stylesheet" href="/GoGreen-APU/assets/css/global/form.css">
    <style>
        .manage-container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .form-card {
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            border-radius: 24px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 40px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; 
            gap: 30px;
            margin-bottom: 20px;
        }

        .full-width { 
            grid-column: span 2; 
        }

        .form-group label {
            display: block;
            margin-bottom: 12px;
            color: #4ade80;
            font-weight: 600;
            font-size: 0.95rem;
            letter-spacing: 0.5px;
        }

        .input-style {
            width: 100%;
            padding: 14px 16px;
            background: rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .input-style:focus {
            border-color: #4ade80;
            outline: none;
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 0 0 3px rgba(74, 222, 128, 0.15);
        }

        .preview-wrapper {
            position: relative;
            width: 100%;
            border-radius: 16px;
            overflow: hidden;
            border: 2px solid rgba(255, 255, 255, 0.1);
            background: rgba(0,0,0,0.2);
            cursor: zoom-in;
            transition: 0.3s;
            box-sizing: border-box;
        }

        .preview-wrapper:hover {
            border-color: #4ade80;
        }

        .current-img-preview {
            width: 100%;
            height: 350px;
            object-fit: cover;
            display: block;
        }

        .preview-tag {
            position: absolute;
            top: 15px;
            left: 15px;
            background: rgba(0, 0, 0, 0.8);
            color: #4ade80;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 700;
            backdrop-filter: blur(4px);
            border: 1px solid rgba(74, 222, 128, 0.3);
            pointer-events: none;
            transition: 0.3s;
        }

        .preview-tag.new-preview {
            background: #4ade80;
            color: #000;
            border-color: #4ade80;
        }

        .upload-box { margin-top: 15px; width: 100%; }

        .file-input-custom {
            width: 100%;
            box-sizing: border-box;
            background: rgba(255, 255, 255, 0.03);
            padding: 12px;
            border-radius: 12px;
            border: 1px dashed rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
            transition: 0.3s;
        }

        .file-input-custom:hover {
            border-color: #4ade80;
            background: rgba(255, 255, 255, 0.06);
            color: white;
        }

        .file-input-custom::file-selector-button {
            background: #4ade80;
            color: #000;
            border: none;
            padding: 8px 18px;
            border-radius: 8px;
            font-weight: 700;
            margin-right: 15px;
            cursor: pointer;
            transition: 0.2s;
        }

        .file-input-custom::file-selector-button:hover {
            background: #22c55e;
        }

        .help-text {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.4);
            margin-top: 8px;
            margin-left: 5px;
        }

        #lightbox {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0,0,0,0.95);
            z-index: 9999;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            backdrop-filter: blur(10px);
        }

        #lightbox img {
            max-width: 90%;
            max-height: 80vh;
            border-radius: 12px;
            box-shadow: 0 0 50px rgba(0,0,0,1);
            cursor: pointer; 
            transition: transform 0.3s;
        }

        .close-lightbox {
            position: absolute;
            top: 30px;
            right: 40px;
            color: white;
            font-size: 50px;
            font-weight: 300;
            cursor: pointer;
            line-height: 1;
            transition: 0.3s;
            z-index: 10000;
        }

        .close-lightbox:hover { color: #4ade80; 
        }

        .btn-container {
            margin-top: 40px;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }

        .btn-save {
            background: #4ade80;
            color: #000;
            padding: 14px 35px;
            border-radius: 12px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            transition: 0.3s;
        }
        .btn-save:hover { 
            background: #22c55e; 
        }

        .btn-cancel {
            background: rgba(255, 255, 255, 0.05);
            color: white;
            padding: 14px 30px;
            border-radius: 12px;
            text-decoration: none;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: 0.3s;
            font-weight: 600;
        }
        .btn-cancel:hover { 
            background: rgba(255, 255, 255, 0.1); 
        }
    </style>
</head>

<body>
    <?php 
    $page_name = 'reward'; 
    include($_SERVER['DOCUMENT_ROOT'] . '/GoGreen-APU/frontend/admin/sidebar.php'); 
    ?>

    <div id="lightbox">
        <span class="close-lightbox" onclick="closeLightbox()">&times;</span>
        <img id="lightbox-img" src="" alt="Fullscreen Preview" onclick="confirmDownload()">
        <p style="color: rgba(255,255,255,0.5); margin-top: 20px; font-size: 0.9rem;">Click the image to Download</p>
    </div>

    <main>
        <div class="page-header">
            <div class="page-header-text">
                <h1 style="color: #4ade80;">Edit Reward</h1>
                <p>Modify reward details, update stock or change status.</p>
            </div>
        </div>

        <div class="manage-container">
            <div class="form-card">
                <form action="/GoGreen-APU/actions/admin/reward/update_reward.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="reward_id" value="<?php echo $reward_data['id']; ?>">

                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>Reward Title</label>
                            <input type="text" name="title" class="input-style" value="<?php echo htmlspecialchars($reward_data['title']); ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Points Cost</label>
                            <input type="number" name="cost" class="input-style" value="<?php echo $reward_data['cost']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Stock Quantity</label>
                            <input type="number" name="quantity" class="input-style" value="<?php echo $reward_data['quantity']; ?>" required>
                        </div>

                        <div class="form-group full-width">
                            <label>Description</label>
                            <textarea name="description" class="input-style" rows="4"><?php echo htmlspecialchars($reward_data['description']); ?></textarea>
                        </div>

                        <div class="form-group full-width">
                            <label style="margin-bottom: 15px;">Reward Image (Click to zoom)</label>
                            
                            <div class="preview-wrapper" onclick="openLightbox()">
                                <?php 
                                $img_path = 'default_placeholder.png';
                                if (!empty($reward_data['image_path'])) {
                                    $img_path = $reward_data['image_path'];
                                }
                                ?>
                                <img id="img-preview" 
                                     src="/GoGreen-APU/assets/images/reward/<?php echo $img_path; ?>" 
                                     class="current-img-preview" 
                                     alt="Reward Image">
                                <div id="preview-label" class="preview-tag">Current Image</div>
                            </div>

                            <div class="upload-box">
                                <input type="file" name="reward_image" id="file-input" class="file-input-custom" accept="image/*">
                                <p class="help-text">Click "Choose File" to see a preview instantly before updating.</p>
                            </div>
                        </div>
                    </div>

                    <div class="btn-container">
                        <a href="index.php" class="btn-cancel">Cancel</a>
                        <button type="submit" class="btn-save">Update Reward</button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        const fileInput = document.getElementById('file-input');
        const imgPreview = document.getElementById('img-preview');
        const previewLabel = document.getElementById('preview-label');
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightbox-img');

        fileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    lightboxImg.src = e.target.result;
                    previewLabel.textContent = "New Preview";
                    previewLabel.classList.add('new-preview');
                }
                reader.readAsDataURL(file);
            }
        });

        function openLightbox() {
            lightboxImg.src = imgPreview.src;
            lightbox.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function confirmDownload() {
            if (confirm("Do you want to download this image?")) {
                const link = document.createElement('a');
                link.href = lightboxImg.src;
                link.download = "reward_image_" + new Date().getTime() + ".jpg";
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === "Escape") closeLightbox();
        });
    </script>
</body>

</html>