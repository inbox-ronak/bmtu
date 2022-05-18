<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add College</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
    <form method="post" action=<?php if(isset($college_obj)) { echo base_url()."/updateCollege/";} else{ echo base_url()."/addCollege/"; } ?>>
    <input type="hidden" name="update_id" id="update_id" value="<?php if(isset($college_obj)) echo $college_obj['id']; ?>" readonly>
        <div class="mb-3">
            <label for="college_name" class="form-label">College Name</label>
            <input type="text" class="form-control" id="college_name" aria-describedby="emailHelp" name="college_name" value="<?php if(isset($college_obj)) echo $college_obj['college_name']; ?>">
        </div>
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-control">
                <option value="1" <?php if(isset($college_obj)) if($college_obj['status'] == '1') echo 'selected'; ?>>Active</option>
                <option value="0" <?php if(isset($college_obj)) if($college_obj['status'] == '0') echo 'selected'; ?>>In-active</option>
            </select>
        </div>
        <?php
        if(isset($college_obj))
        {
            echo '<button type="submit" class="btn btn-info">Update</button>';
        }else{
            echo '<button type="submit" class="btn btn-Success">Save</button>';
        }
        ?>
    </form>
</body>
</html>