<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-primary">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                    Data Barang
                </h4>
            </div>
            <div class="col-auto">
                <a href="#" class="btn btn-sm btn-primary btn-icon-split" data-toggle="modal" data-target="#addModal">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Tambah Barang
                    </span>
                </a>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Nama Barang</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($barang as $key => $data) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data->nama ?></td>
                        <td><?= $data->stok ?></td>
                        <td><?= ' Rp. ' . number_format($data->harga)  ?></td>
                        <td>
                            <a href="#" class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#detailModal"><i class="fa fa-eye"></i></a>
                            <a href="<?= base_url('sepatu/edit/') . $data->id_barang?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                            <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('sepatu/delete/') . $data->id_barang ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Modal-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Data Sepatu</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <?= $this->session->flashdata('pesan'); ?>
                    <form action="<?php echo base_url('sepatu/add') ?>" class="form" method="post">
                        <div class="row form-group">
                            <label class="col-md-3 text-md-right" for="nama_barang">Nama</label>
                            <div class="col-md-9">
                                <input value="<?= set_value('nama_barang'); ?>" name="nama_barang" id="nama_barang" type="text" class="form-control" placeholder="Nama Barang...">
                                <?= form_error('nama_barang', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-3 text-md-right" for="nama_barang">Stok</label>
                            <div class="col-md-9">
                                <input value="<?= set_value('stok'); ?>" name="stok" id="stok" type="number" class="form-control" placeholder="Stok...">
                                <?= form_error('stok', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-3 text-md-right" for="nama_barang">Harga Jual</label>
                            <div class="col-md-9">
                                <input value="<?= set_value('harga'); ?>" name="harga" id="harga" type="number" class="form-control" placeholder="Harga Jual...">
                                <?= form_error('harga', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-md-9 offset-md-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                                <button type="reset" class="btn btn-secondary">Reset</bu>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>