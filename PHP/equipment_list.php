<!-- Equipment List -->
<h2>Equipment List</h2>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['description']; ?></td>
            <td><?php echo $row['category']; ?></td>
            <td>
                <a href="manage_equipment.php?edit=<?php echo $row['id']; ?>">Edit</a>
                <a href="manage_equipment.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this equipment?')">Delete</a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
