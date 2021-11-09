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
                        Enry Transaksi
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
                    <th>Harga Jual</th>
                    <th>Jumlah</th>
                    <th>Total</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                foreach ($transaksi as $key => $data) {
                ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data->nama ?></td>
                        <td><?= ' Rp. ' . number_format($data->harga)?></td>
                        <td><?= $data->jumlah ?></td>
                        <td><?= ' Rp. ' . number_format($data->total)  ?></td>
                        <td><?= $data->tanggal ?></td>
                        <td>
                            <a href="#" class="btn btn-success btn-circle btn-sm" data-toggle="modal" data-target="#detailModal"><i class="fa fa-eye"></i></a>
                            <a href="<?= base_url('transaksi/edit/') . $data->id_barang ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                            <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('transaksi/delete/') . $data->id_barang ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
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
                    <form action="<?php echo base_url('transaksi/add') ?>" class="form" method="post">
                        <div class="row form-group">
                            <label class="col-md-3 text-md-right" for="barang_id">Nama</label>
                            <div class="col-md-9">
                                <div class="input-group">
                                    <select name="barang_id" id="barang_id" class="custom-select" >
                                        <option value="" selected disabled>Pilih Barang</option>
                                        <?php foreach ($barang as $key => $data) : ?>
                                            <option <?= set_select('barang_id', $data['id_barang']) ?> value="<?= $data['id_barang'] ?>"><?= $data['nama'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <a class="btn btn-primary" href="<?= base_url('jenis/add'); ?>"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <?= form_error('barang_id', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-3 text-md-right" for="tanggal_masuk">Tanggal</label>
                            <div class="col-md-9">
                                <input value="<?= set_value('tanggal_masuk', date('Y-m-d')); ?>" name="tanggal" id="tanggal_masuk" type="text" class="form-control date" placeholder="Tanggal Masuk...">
                                <?= form_error('tanggal_masuk', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-3 text-md-right" for="harga">Harga Barang</label>
                            <div class="col-md-9">
                                <input readonly="readonly" name="harga" id="harga" type="number" class="form-control">
                                <?= form_error('harga', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-3 text-md-right" for="jumlah">jumlah</label>
                            <div class="col-md-9">
                                <input value="<?= set_value('jumlah'); ?>" name="jumlah" id="jumlah" type="number" class="form-control" placeholder="jumlah...">
                            </div>
                            <?= form_error('jumlah_keluar', '<small class="text-danger">', '</small>'); ?>
                        </div>
                        <div class="row form-group">
                            <label class="col-md-3 text-md-right" for="total">Total</label>
                            <div class="col-md-9">
                                <input readonly="readonly" name="total_harga" id="total_harga" type="number" class="form-control">
                                <?= form_error('total_harga', '<small class="text-danger">', '</small>'); ?>
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