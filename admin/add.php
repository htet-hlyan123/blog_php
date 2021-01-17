<?php
require '../config/config.php';
session_start();
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) ){
  header('Location: login.php');
}
if($_POST){
  $file = 'images/'.($_FILES['image']['name']);
  $imageType = pathinfo($file, PATHINFO_EXTENSION);
  if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
    echo "<script>alert('image must be png,jpg,jpeg')</script>";
  }else {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image = $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], $file);
    $stmt = $pdo->prepare( "INSERT INTO posts(title,content,author_id,image) VALUES(:title,:content,
      :author_id,:image)" );
    $result = $stmt->execute(
      array(':title'=>$title, ':content'=>$content, ':author_id'=>$_SESSION['id'], ':image'=>$image, )
    );
    if($result)
      echo "<script>alert('Successfully added');window.location.href='index.php';</script>";

  }//else
}
?>

<?php include 'header.html';?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form method="post" action="add.php" enctype="multipart/form-data">
                  <div class="form-group">
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="title" value="" required>
                  <div><br>
                  <div class="form-group">
                    <label for="">Content</label>
                    <textarea name="content" class="form-control" rows="8" cols="80"></textarea>
                  </div>
                  <div class="form-group">
                    <label for="">Image</label>
                    <input type="file" name="image" value="" required>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="" value="SUBMIT" class="btn btn-success">
                    <a href="add.php" type="button" class="btn btn-warning">BACK</a>
                  </div>
                </form>
              </div>
            </div>

          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

<?php include 'footer.html';
