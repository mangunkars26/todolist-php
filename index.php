<?php 
include "database.php";

//proses_insert_data
if(isset($_POST['add'])){
    if(empty($_POST['task'])){
        echo "Tak boleh kosong!";
    }else{
        $q_insert = "INSERT INTO tasks (task_label,task_status) VALUES (
            '".mysqli_real_escape_string($conn, $_POST['task'])."',
            'open'
        )";
        $run_q_insert = mysqli_query($conn, $q_insert);
        if($run_q_insert){
            header('Refresh:0; url=index.php');
        }
    }
}
//proses_show_data
$q_select       = "SELECT * FROM tasks ORDER BY task_id DESC";
$run_q_select   = mysqli_query($conn,$q_select);

//proses_delete_data
if(isset($_GET['delete'])){
    $q_delete = "DELETE FROM tasks WHERE task_id = '".$_GET['delete']."' ";
    $run_q_delete = mysqli_query($conn, $q_delete);

    header('Refresh:0; url=index.php');
}

//proses_update_close_&_open

if(isset($_GET['done'])){
    $status = 'close';

    if($_GET['status'] == 'open'){
        $status = 'close';
    }else{
        $status = 'open';
    }

    $q_update = " UPDATE tasks SET task_status = '".$status."' WHERE task_id = '".$_GET['done']."' ";
    $run_q_update = mysqli_query($conn, $q_update);

    header('Refresh:0; url=index.php');
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap');
        *{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Roboto', sans-serif;
            background: #0F2027;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #2C5364, #203A43, #0F2027); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */

        }
        .container {
            width: 590px;
            height: 100vh;
            margin: 0 auto;
        }
        .header{
            padding: 15px;
            color: #ffffff;
        }

        .header .title {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
        }

        .header.title i{
            font-size: 24px;
            margin-right: 10px;
        }
        .header .title span{
            font-size: 18px;
        }
        .header .description{
            font-size: 13px;
        }
        .content{
            padding: 15px;

        }
        .card{
            background-color: #ffffff;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .input-control{
            width: 100%;
            display: block;
            padding: 0.5rem;
            font-size: 1 rem;
            margin-bottom: 10px;
        }
        .text-right{
            text-align: right;
        }
        button{
            padding: 0.5rem 1rem;
            font-size: 1rem;
            cursor: pointer;
            background: #0F2027;  /* fallback for old browsers */
            background: -webkit-linear-gradient(to right, #2C5364, #203A43, #0F2027);  /* Chrome 10-25, Safari 5.1-6 */
            background: linear-gradient(to right, #2C5364, #203A43, #0F2027); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
            color:#fff;
            border: 1px solid;
            border-radius: 4px;
        }
        .task-item{
            display: flex;
            justify-content: space-between;
        }
        .text-orange{
            color: orangered;
            margin-right: 5px;
        }
        .text-red{
            color:red;
        }
        .task-item.done{
            text-decoration: line-through;
            color: #2C5364;
        }
        .warning-text h1{
            color: #fff;
        }
        @media(max-width: 768px){
            .container{
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="title">
                <div class="bx bx-sun"></div>
                <span>Todo List</span>
            </div>
            <div class="description">
                <?= date("l,d M Y") ?>
            </div>
        </div>
        <div class="content">
            <div class="card">
                <form action=""method="post" >
                    <input type="text" name="task" class="input-control" placeholder="Add Task">
                        <div class="text-right">
                            <button  type="submit" name="add">
                                Add
                            </button>
                        </div>
                </form>
            </div>

            <?php 
                if(mysqli_num_rows($run_q_select) > 0 ){

                    while($r = mysqli_fetch_array($run_q_select)){ 
                        ?>
            <div class="card">
                <div class="task-item <?= $r['task_status'] == 'close' ? 'done':''?> ">
                    <div>
                        <input type="checkbox" onclick=" window.location.href = '?done=<?= $r['task_id'] ?>&status=<?= $r['task_status']?>'" <?= $r['task_status'] == 'close' ? 'checked' : '' ?>>
                        <span><?= $r['task_label']?></span>
                    </div>
                    <div>
                        <a href="edit.php?id= <?= $r['task_id'] ?>"
                         class="text-orange" title="Edit"><i class="bx bx-edit"></i></a>
                        <a href="?delete=<?= $r['task_id']?>" class="text-red" title="Remove"onclick ="return confirm('Yakin Lu Mau Hapus?')">
                            <i class="bx bx-trash"></i></a>
                    </div>
                </div>
            </div>
                <?php }} else{ ?>
                    <div class="warning-text">
                        <h1>No Task Added!</h1>
                    </div>
              <?php  } ?>


        </div>
    </div>
</body>

</html>