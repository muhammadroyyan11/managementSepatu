<div class="row justify-content-center">
    <div class="col-md-12">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Detail Transaksi
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('transaksi') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <table class="table table-bordered no-margin">
                    <tbody>
                        <tr>
                            <th style="width: 35%;">Nama</th>
                            <td><span id="nama"></span><?= $transaksi['nama']?></td>
                        </tr>
                        <tr>
                            <th style="width: 35%;">Harga Jual</th>
                            <td><span id="nama"></span><?= ' Rp. ' . number_format($transaksi['harga'])  ?></td>
                        </tr>
                        <tr>
                            <th style="width: 35%;">Jumlah</th>
                            <td><span id="nama"></span><?= $transaksi['jumlah']?></td>
                        </tr>
                        <tr>
                            <th style="width: 35%;">Harga</th>
                            <td><span id="harga"></span><?= ' Rp. ' . number_format($transaksi['total'])  ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>