<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>College</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <table class="table">
        <thead>
            <th>Action</th>
            <th>College Name</th>
            <th>Status</th>
        </thead>
        <tbody>
            <?php
            foreach ($college as $key => $value) { ?>
                <tr>
                    <td>
                        <div class="d-flex">
                            <div class="m-1">
                                <form action=<?php echo base_url()."/editCollege"; ?> method="post">
                                <input type="hidden" name="edit_id" <?php echo "value=".$value['id'].""; ?>>
                                    <button type="submit" class="btn btn-danger"><i class="fa-solid fa-pen-to-square"></i></button>
                                </form>
                            </div>
                            <div class="m-1">
                                <a class="btn btn-danger" href=<?php echo base_url()."/deleteCollege/".$value['id']; ?> onclick="return confirm('Are you sure to delete this college?');"><i class="fa-solid fa-trash-can"></i></a>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?= $value['college_name']; ?>
                    </td>
                    <td><?= ($value['status'] == '1') ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-danger">In-active</span>'; ?></td>
                </tr>
            <?php }
            ?>
        </tbody>
    </table>
</body>
</html>