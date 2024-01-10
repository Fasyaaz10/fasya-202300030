<div class="row">
<div class="col-md-12">
          <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">Data Bagiant</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-primary btn-xm btn-flat" data-toggle="modal" data-target="#tambah">
                  <i class="fa fa-plus"> Tambah</i></button>
              </div>
              <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <?php 
            if (session()->getFlashdata('pesan')){
            echo '<div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Success! - ';
            echo session()->getFlashdata('pesan');
            echo '</h4></div>';
            }
            ?>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="80px">No</th>
                            <th>Bagian</th>
                            <th width="100px">Opsi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1;
                         foreach ($dep as $key => $value) { ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $value ['nama_dep']; ?></td>
                                <td class="text-center">
                                  <button class="btn btn-xs btn-warning" data-toggle="modal" data-target="#edit<?= $value['id_dep']; ?>">Edit</button>
                                  <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#delete<?= $value['id_dep']; ?>">Delete</button>
                                </td>
                        </tr>
                      <?php  } ?>
                    </tbody>
                </table>
              
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
</div>

<!-- modal tambah -->
<div class="modal fade" id="tambah">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Bagian</h4>
              </div>
              <div class="modal-body">
                <?php
                echo form_open('dep/tambah') 
                ?>

                <div class="form-group">
                  <label>Nama Bagian</label>
                  <input name="nama_dep" class="form-control" placeholder="Bagian">
                </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
              </div>
              <?php echo form_close() ?>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <!-- modal edit -->
        <?php foreach ($dep as $key => $value) { ?>

        <div class="modal fade" id="edit<?= $value ['id_dep']; ?>">
          <div class="modal-dialog modal-sm">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Edit Bagian</h4>
              </div>
              <div class="modal-body">
                <?php
                echo form_open('dep/edit/'. $value ['id_dep']) 
                ?>

                <div class="form-group">
                  <label>Nama Bagian</label>
                  <input name="nama_dep" value="<?= $value ['nama_dep']; ?>" class="form-control" placeholder="Bagiant">
                </div>


              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update</button>
              </div>
              <?php echo form_close() ?>
            </div>
            <!-- /.modal-content -->
          </div>
          <!-- /.modal-dialog -->
        </div>
        <?php } ?>
        <!-- /.modal -->
        
 <!-- modal delete -->
 <?php foreach ($dep as $key => $value) { ?>

<div class="modal fade" id="delete<?= $value ['id_dep']; ?>">
  <div class="modal-dialog modal-sm modal-danger">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Hapus Nama Bagian</h4>
      </div>
      <div class="modal-body">
        Apakah ingin menghapus data <?= $value ['nama_dep']; ?> ..?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tidak</button>
        <a href="<?= base_url('dep/delete/'.$value['id_dep']) ?>" type="submit" class="btn btn-primary">Hapus</a>
      </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<?php } ?>
<!-- /.modal -->

      