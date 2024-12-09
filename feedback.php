<div class="reviews-column">
    <?php
    include('db.php'); // Include the database connection file

    // Check if a delete request has been sent
    if (isset($_GET['delete_review'])) {
        $review_id = $_GET['delete_review'];

        // SQL query to delete the review
        $delete_sql = "DELETE FROM reviews WHERE id = ?";
        $stmt = $conn->prepare($delete_sql);

        if ($stmt) {
            $stmt->bind_param('i', $review_id);
            if ($stmt->execute()) {
                echo "<p class='success-message'>Review deleted successfully.</p>";
            } else {
                echo "<p class='error-message'>Error deleting review: " . $stmt->error . "</p>";
            }
        } else {
            echo "<p class='error-message'>Error preparing query: " . $conn->error . "</p>";
        }
    }

    // SQL query to fetch reviews ordered by created_at
    $sql = "SELECT * FROM reviews ORDER BY created_at DESC";
    $result = $conn->query($sql);

    // Check if there are reviews
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            ?>
            <div class="review-item">
                <div class="review-content">
                    <p>"<?= htmlspecialchars($row['review_text']) ?>"</p>
                </div>
                <div class="reviewer">
                    <?php if (!empty($row['customer_photo'])) { ?>
                        <img src="IMG/<?= htmlspecialchars($row['customer_photo']) ?>" alt="<?= htmlspecialchars($row['customer_name']) ?>">
                    <?php } else { ?>
                        <img src="IMG/default-avatar.png" alt="Default Avatar">
                    <?php } ?>
                    <div>
                        <h4><?= htmlspecialchars($row['customer_name']) ?></h4>
                        <p><?= htmlspecialchars($row['event_type']) ?></p>
                    </div>
                </div>
                <!-- Edit Button -->
                <a href="edit.php?edit_review=<?= $row['id'] ?>" class="edit-button">
                    <button>Edit</button>
                </a>
                <!-- Delete Button -->
                <a href="?delete_review=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this review?')">
                    <button class="delete-button">Delete</button>
                </a>
            </div>
            <?php
        }
    } else {
        echo '<p>No reviews available at the moment. Please check back later!</p>';
    }

    // Close the database connection
    $conn->close();
    ?>
</div>
<a href="admin_homepage.php" class="Back">Back</a>



<style>
    .Back {
            display: inline-block;
            background-color: ##614a4a;
            color: #pink;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 16px;
            font-weight: bold;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .Back:hover {
            background-color: #f4a2c4;
            transform: scale(1.05);
        }
/* Success and Error Messages */
.success-message {
    color: green;
    font-weight: bold;
    text-align: center;
    margin-bottom: 1rem;
}

.error-message {
    color: red;
    font-weight: bold;
    text-align: center;
    margin-bottom: 1rem;
}

/* Reviews Column Layout */
.reviews-column {
    display: flex;
    flex-direction: column; /* Stacks items vertically */
    gap: 1.5rem; /* Space between items */
    align-items: center; /* Centers content horizontally */
    padding: 2rem;
}

/* Review Item */
.review-item {
    background-color: #fff;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
    width: 100%;
    max-width: 600px; /* Set a maximum width for better readability */
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
}

.review-item:hover {
    transform: translateY(-10px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
}

/* Review Content */
.review-content {
    font-style: italic;
    color: #555;
    margin-bottom: 1.5rem;
    text-align: center;
}

/* Reviewer Section */
.reviewer {
    display: flex;
    align-items: center;
    text-align: left;
    width: 100%;
    margin-top: 1rem;
}

.reviewer img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 50%;
    margin-right: 1rem;
    border: 2px solid #ddd;
}

.reviewer h4 {
    font-size: 1.2rem;
    color: #333;
    margin-bottom: 0.2rem;
}

.reviewer p {
    font-size: 1rem;
    color: #777;
}

/* Delete Button */
.delete-button {
    background-color: #ff4d4d;
    color: #fff;
    border: none;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s ease, transform 0.2s ease;
}

.delete-button:hover {
    background-color: #e60000;
    transform: scale(1.05);
}

/* Responsive Design */
@media (max-width: 768px) {
    .review-item {
        padding: 1.5rem;
    }

    .reviewer img {
        width: 40px;
        height: 40px;
    }

    .reviewer h4 {
        font-size: 1rem;
    }

    .reviewer p {
        font-size: 0.9rem;
    }
}
* Edit Button Styling */
    .edit-button {
        text-decoration: none; /* Remove underline from the link */
    }

    .edit-button button {
        background-color: #ffb6c1; /* Light pink color */
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.2s ease;
    }

    .edit-button button:hover {
        background-color: #ff69b4; /* Darker pink on hover */
        transform: scale(1.05); /* Slightly increase size on hover */
        box-shadow: 0 4px 12px rgba(255, 105, 180, 0.3); /* Subtle shadow effect */
    }

    .edit-button button:focus {
        outline: none; /* Remove focus outline */
        box-shadow: 0 0 0 3px rgba(255, 105, 180, 0.5); /* Add glow effect on focus */
    }

</style>
