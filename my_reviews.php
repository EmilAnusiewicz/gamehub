<?php

require("session.php");
require("db.php");
require("header.php");

$user_id = $_SESSION["id"];

$result = mysqli_query(
    $conn,
    "
    SELECT
        reviews.*,
        games.title,
        games.cover
    FROM reviews
    JOIN games
        ON reviews.game_id = games.id
    WHERE reviews.user_id = $user_id
    ORDER BY reviews.created_at DESC
    "
);

?>

<div class="container">

    <h1 class="section-title">
        📝 Moje recenzje
    </h1>

    <?php if(mysqli_num_rows($result) > 0): ?>

        <div class="reviews-list">

            <?php while($review = mysqli_fetch_assoc($result)): ?>

                <div class="review-card">

    <div class="review-game">

        <img
    src="uploads/covers/<?= htmlspecialchars($review["cover"]) ?>"
    class="review-cover"
    alt="">

        <div class="review-info">

                    <div class="review-header">

                        <h3>
                            <?= htmlspecialchars($review["title"]) ?>
                        </h3>

                        <div class="review-score">
                            ⭐ <?= $review["score"] ?>/10
                        </div>

                    </div>

                    <p class="review-content">

                        <?= nl2br(htmlspecialchars($review["content"])) ?>

                    </p>
                    </div>
                    </div>


                    <div class="review-actions">

    <a
        href="edit_review.php?id=<?= $review["id"] ?>"
        class="btn">

        ✏️ Edytuj

    </a>

    <a
    href="delete_review.php?id=<?= $review["id"] ?>"
    class="btn btn-danger delete-btn">

    🗑 Usuń

</a>

    <a
        href="details.php?id=<?= $review["game_id"] ?>"
        class="btn">

        🎮 Szczegóły

    </a>

</div>

                </div>

            <?php endwhile; ?>

        </div>

    <?php else: ?>

        <div class="empty-box">

            Nie dodałeś jeszcze żadnej recenzji.

        </div>

    <?php endif; ?>

</div>

<?php require("footer.php"); ?>