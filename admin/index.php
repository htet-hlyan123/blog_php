<?php
session_start();
if( empty($_SESSION['user_id']) && empty($_SESSION['logged_in']) ){
  header('Location: login.php');
}
?>

<?php include 'header.html';?>
    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Blog Listing</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

                <?php
                  require '../config/config.php';
                  $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                  $stmt->execute();
                  $result = $stmt->fetchAll();
                ?>

                <div>
                  <a href="add.php" type="button" class="btn btn-success">New Blog Post</a>
                </div><br>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Title</th>
                      <th>Description</th>
                      <th style="width: 40px">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $i=1;
                      if($result){
                        foreach ($result as $value) {
                    ?>
                    <tr>
                      <td><?php echo $i;?></td>
                      <td><?php echo $value['title'];?></td>
                      <td><?php echo substr($value['content'], 0, 400);?></td>
                      <td>
                        <div class="btn-group">
                          <div class="container">
                            <a href="edit.php?id=<?php echo $value['id'];?>" type="button" class="btn btn-warning">Edit</a>
                          </div>
                          <div class="container">
                            <a href="delete.php?id=<?php echo $value['id'];?>"
                              onclick="return confirm('Are you sure to delete')" type="button" class="btn btn-danger">Delete</a>
                          </div>
                        </div>

                      </td>
                    </tr>

                    <?php
                    $i++;
                        }
                      }
                    ?>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
              <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">&laquo;</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">&raquo;</a></li>
                </ul>
              </div>
            </div>

          </div>

        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

<?php include 'footer.html';
