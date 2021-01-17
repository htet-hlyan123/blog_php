<?php
require '../config/config.php';
session_start();
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) ){
  header('Location: login.php');
}
if($_POST){
  if($_FILES['image']['name'] != null) {
    $id = $_POST['id'];
    $file = "images/".($_FILES['image']['name']);
    $imageType = pathinfo($file, PATHINFO_EXTENSION);
    if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg') {
      echo "<script>alert('Image must be png,jpg,jpeg')</script>";
    } else {//inner else
      $title = $_POST['title'];
      $content = $_POST['content'];
      $image = $_FILES['image']['name'];
      move_uploaded_file($_FILES['image']['tmp_name'], $file);
      $stmt = $pdo->prepare( "UPDATE posts SET title='$title',content='$content',image='$image' where id='$id'" );
      $result = $stmt->execute();
      if($result)
        echo "<script>alert('Successfully added');window.location.href='index.php';</script>";
    }//inner else
  }//$_FILE if
    else {
      $stmt = $pdo->prepare( "UPDATE posts SET title='$title',content='$content' where id='$id'" );
      $result = $stmt->execute();
      if($result)
        echo "<script>alert('Successfully added');window.location.href='index.php';</script>";
    }//outer else
}//post if

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();
?>
<?php include 'header.html';?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form method="post" action="" enctype="multipart/form-data">
                  <div class="form-group">
                    <input type="hidden" name="id" value="<?php echo $result[0]['id'];?>">
                    <label for="">Title</label>
                    <input type="text" class="form-control" name="title" value="<?php echo $result[0]['title'];
                    ?>" required>
                  <div><br>
                  <div class="form-group">
                    <label for="">Content</label>
                    <textarea name="content" class="form-control" rows="8" cols="80"><?php
                    echo substr($result[0]['content'], 0, 50);?></textarea>
                  </div>
                  <div class="form-group">
                    <image src="images/<?php echo $result[0]['image'];?>" width="150" height="150" alt=""><br><br>
                    <label for="">Image</label>
                    <input type="file" name="image" value="" required>
                  </div>
                  <div class="form-group">
                    <input type="submit" name="" value="EDIT" class="btn btn-success">
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
