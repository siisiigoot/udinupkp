<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu" id="side-menu">
                <li class="menu-title">Main</li>
                <li>
                    <a href="/dashboard" class="waves-effect">
                        <i class="mdi mdi-home"></i><span class="badge badge-primary float-right"></span> <span> Dashboard </span>
                    </a>
                </li>
                @if (auth()->user()->role === 'admin')

                <li class="menu-title">Menu Admin</li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-table-settings"></i><span> Master Data <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="{{ route('pegawai') }}">Pegawai</a></li>
                        <li><a href="#">Golongan</a></li>
                        <li><a href="tables-responsive.html">Jabatan</a></li>
                        <li><a href="tables-editable.html">Pendidikan</a></li>
                        <li><a href="tables-editable.html">Unit Kerja</a></li>
                        <li><a href="tables-editable.html">Perangkat Daerah</a></li>
                        <li><a href="tables-editable.html">Instansi</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-format-list-numbers"></i><span> Proses Pendaftaran <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="{{ route('verifikasi') }}">Daftar Usulan</a></li>
                        <li><a href="#">Daftar Peserta</a></li>
                        <li><a href="#">Cetak Kartu</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-google-pages"></i><span> Bank Soal <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="#">Soal Tes</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript:void(0);" class="waves-effect"><i class="mdi mdi-settings"></i><span> Pengaturan <span class="float-right menu-arrow"><i class="mdi mdi-plus"></i></span> </span></a>
                    <ul class="submenu">
                        <li><a href="{{ route('user') }}">Akun</a></li>
                        <li><a href="{{ route('ujian') }}">Jenis Ujian</a></li>
                        <li><a href="{{ route('sub_ujian') }}">Sub Jenis Ujian</a></li>
                        <li><a href="{{ route('dokumen') }}">Dokumen</a></li>
                        <li><a href="#">Jadwal Tes</a></li>
                        <li><a href="#">Sesi Tes</a></li>
                    </ul>
                </li>
                @else
                <li class="menu-title">Menu Fasilitator</li>
                <li>
                    <a href="{{ route('pegawai') }}" class="waves-effect">
                        <i class="mdi mdi-table-settings"></i><span class="badge badge-primary float-right"></span> <span> Data Pegawai </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pengantar') }}" class="waves-effect">
                        <i class="mdi mdi-file-document-box"></i><span class="badge badge-primary float-right"></span> <span> Surat Pengantar </span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('pendaftaran') }}" class="waves-effect"><i class="mdi mdi-folder-multiple"></i><span> <span> Daftar Usulan </span> </span></a>
                </li>
                @endif
            </ul>

        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>