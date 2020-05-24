<?php require APPROOT . '/views/inc/header.php'; ?>
    <a href="<?php echo URLROOT;?>/posts/index" class="btn btn-light"><i class = "fa fa-hand-o-left"> Back</i> </a>
        <div class = "card card-body bg-light mt-5">
         <h3> Edit Post</h3>
         <p> Create a post with this form </p>
            <form action="<?php echo URLROOT; ?>/posts/edit/<?php echo $data['id']; ?>" method="POST">
            
                <div class="form-group">
        <label for="title">Title: <sup>*</sup></label>
        <input type="text" name="title" class="form-control form-control-lg <?php echo (!empty($data['title_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['title']; ?>">
        <span class="invalid-feedback"><?php echo $data['title_err']; ?></span>
                </div>
                
                <div class="form-group">
                    <label for="body">Body <sup>*</sup></label>
                    <textarea name="body" class="form-control form-control-lg <?php
                    echo(!empty($data['body_err'])) ? 'is-invalid' : '';/*ako ima geska dodajemo bootstrap klasu koja menja boju*/ ?>" ><?php echo $data['body'];?></textarea>
                    <span class = "invalid-feedback"><?php echo $data['body_err'];?></span>
                </div> 
                <input type = "submit" class="btn btn-success" value="Submit">
            </form>
        </div>
<?php require APPROOT . '/views/inc/footer.php'; ?>