<section class="content">
  <span id="pesan-flash"><?php echo $this->session->flashdata('sukses'); ?></span>
  <div class="row">
    <div class="col-md-4">
      <div class="box">
        <div class="box-header">
          <i class="fa fa-plus"></i>
          <h3 class="box-title">Form Kategori</h3>
        </div>
        <div class="box-body chat" id="chat-box">
          <!-- chat item -->
          <div class="item">
            <form role="form" action="<?php echo base_url(); ?>category/save" method="post">
              <div class="form-group">
                <label for="namalengkap">Nama</label>
                <input type="text" class="form-control" value="<?php echo $category_name; ?>" id="" name="category_name"  required>
              </div>
              <input type="hidden" name="idcategory" value="<?php echo $idcategory; ?>" />
              <input type="hidden" name="status" value="<?php echo $status; ?>" />
              <button type="submit" class="btn btn-primary btn-block btn-flat">Simpan</button>
              <?php if($status == "baru"){ echo '<button type="reset" class="btn btn-warning btn-block btn-flat">Batal</button>';?>
              <?php } else { ?> 
              <a href="<?php echo base_url(); ?>category" class="btn btn-warning btn-block btn-flat">Kembali</a>
              <?php } ?>
            </form>
          </div><!-- /.item -->
         
        </div><!-- /.chat -->
      </div>
    </div>
    <div class="col-md-8">
      <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo $title ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nama</th>
                  <th width="20%">Aksi</th>
                </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php foreach ($categories as $category) { ?>
                    <td><a href="<?php echo base_url('category/view/'.$category->idcategory)?>"><?php echo $category->category_name; ?></a></td>
                    <td>
                      <a class="btn btn-info btn-sm" href="<?php echo base_url(); ?>category/edit/<?php echo $category->idcategory; ?>">Edit</a> ||
                      <a onclick="return confirm('Apakah anda yakin ?');" class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>category/delete/<?php echo $category->idcategory; ?>">Hapus</a>
                    </td>
                    </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nama</th>
                  <th width="20%">Aksi</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
      <!-- /.box -->
      
    </div>
    <!-- /.col-->
  </div>
  <!-- ./row -->
</section>


