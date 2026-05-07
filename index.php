<?php
require_once 'includes/db_connect.php';

$category_filter = isset($_GET['category']) ? $_GET['category'] : 'Tutte';
$sql = "SELECT * FROM media_contents";

if ($category_filter != 'Tutte') {
    $sql .= " WHERE category = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $category_filter);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    $sql .= " ORDER BY created_at DESC";
    $result = mysqli_query($conn, $sql);
}
?>
<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lanificio Maurizio Sella - Viaggio nel tempo</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <header>
        <h1>Lanificio Maurizio Sella</h1>
        <a href="admin/dashboard.php" style="margin-left: auto;" class="btn">Area Privata</a>
    </header>

    <main>
        <h2>Galleria Multimediale - <?php echo htmlspecialchars($category_filter); ?></h2>

        <nav>
            <a href="index.php">Tutti</a>
            <a href="index.php?category=Tradizione">Tradizione</a>
            <a href="index.php?category=Innovazione">Innovazione</a>
        </nav>
        <div class="gallery">
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <div class="gallery-item">
                    <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                    <?php if ($row['media_type'] == 'youtube'): ?>
                        <?php
                        // usata ia perche non riuscivo a prendere ID
                        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $row['file_path'], $match);
                        $youtube_id = isset($match[1]) ? $match[1] : '';
                        ?>
                        <div class="media-wrapper">
                            <div class="play-icon">&#9658;</div>
                            <img src="https://img.youtube.com/vi/<?php echo $youtube_id; ?>/maxresdefault.jpg"
                                alt="<?php echo htmlspecialchars($row['title']); ?>" class="clickable-youtube"
                                data-youtube-id="<?php echo $youtube_id; ?>"
                                style="width: 100%; display: block; object-fit: cover;">
                        </div>
                    <?php elseif ($row['media_type'] == 'video'): ?>
                        <div class="media-wrapper">
                            <div class="play-icon">&#9658;</div>
                            <video width="100%" class="clickable-video">
                                <source src="<?php echo htmlspecialchars($row['file_path']); ?>" type="video/mp4">
                                Il tuo browser non supporta i video HTML5.
                            </video>
                        </div>
                    <?php elseif ($row['media_type'] == 'image'): ?>
                        <img src="<?php echo htmlspecialchars($row['file_path']); ?>"
                            alt="<?php echo htmlspecialchars($row['title']); ?>" width="100%" class="clickable-image">
                    <?php endif; ?>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </main>

    <!-- Modal per i Media (Video, Immagini e YouTube) -->
    <div id="media-modal" class="video-modal">
        <span class="close-modal">&times;</span>
        <video id="modal-video" controls controlsList="nofullscreen nodownload" style="display:none;">
            <source src="" type="video/mp4">
            Il tuo browser non supporta i video HTML5.
        </video>
        <img id="modal-image" src="" alt="" style="display:none;">
        <iframe id="modal-youtube" src="" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen style="display:none;"></iframe>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const clickableVideos = document.querySelectorAll('.clickable-video');
            const clickableImages = document.querySelectorAll('.clickable-image');
            const clickableYoutubes = document.querySelectorAll('.clickable-youtube');
            const mediaModal = document.getElementById('media-modal');
            const modalVideo = document.getElementById('modal-video');
            const modalImage = document.getElementById('modal-image');
            const modalYoutube = document.getElementById('modal-youtube');
            const closeModal = document.querySelector('.close-modal');

            // Apertura Video HTML5
            clickableVideos.forEach(video => {
                const wrapper = video.closest('.media-wrapper') || video;
                wrapper.addEventListener('click', () => {
                    const source = video.querySelector('source').src;
                    modalVideo.querySelector('source').src = source;
                    modalVideo.load();
                    modalVideo.style.display = 'block';
                    modalImage.style.display = 'none';
                    modalYoutube.style.display = 'none';
                    mediaModal.style.display = 'flex';
                    modalVideo.play();
                });
            });

            // Apertura Immagine
            clickableImages.forEach(img => {
                img.addEventListener('click', () => {
                    modalImage.src = img.src;
                    modalImage.style.display = 'block';
                    modalVideo.style.display = 'none';
                    modalYoutube.style.display = 'none';
                    mediaModal.style.display = 'flex';
                });
            });

            // Apertura YouTube
            clickableYoutubes.forEach(yt => {
                const wrapper = yt.closest('.media-wrapper') || yt;
                wrapper.addEventListener('click', () => {
                    const ytId = yt.getAttribute('data-youtube-id');
                    modalYoutube.src = 'https://www.youtube.com/embed/' + ytId + '?autoplay=1';
                    modalYoutube.style.display = 'block';
                    modalImage.style.display = 'none';
                    modalVideo.style.display = 'none';
                    mediaModal.style.display = 'flex';
                });
            });

            // Chiusura Modal
            const hideModal = () => {
                mediaModal.style.display = 'none';
                modalVideo.pause();
                modalVideo.querySelector('source').src = '';
                modalImage.src = '';
                modalYoutube.src = ''; // ferma il video youtube
            };

            closeModal.addEventListener('click', hideModal);

            mediaModal.addEventListener('click', (e) => {
                if (e.target === mediaModal) {
                    hideModal();
                }
            });
        });
    </script>
</body>

</html>