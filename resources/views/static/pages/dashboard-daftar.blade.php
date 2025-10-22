@extends('static.layouts.layout')

@section('content')
  <section class="dashboard">
    <div class="wrapper">
      <div class="dashboard__left">
        <h6>DASHBOARD</h6>
        <nav>
          <ul>
            <li>
              <a href="{{ route('front.dashboard') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="23" height="24" viewBox="0 0 23 24" fill="none">
                  <path d="M22.4397 14.6049L21.2603 13.4341C20.9064 13.0829 20.4051 12.878 19.9038 12.878C19.3731 12.878 18.9013 13.0829 18.5474 13.4341L12.0603 19.9024C11.8833 20.078 11.7949 20.2829 11.7949 20.5171V23.122C11.7949 23.6195 12.1782 24 12.6795 24H15.3038C15.5397 24 15.7756 23.9122 15.9231 23.7366L22.4397 17.2976C22.7936 16.9463 23 16.4488 23 15.9512C23 15.4537 22.7936 14.9561 22.4397 14.6049ZM19.9038 14.6341C19.9333 14.6341 19.9923 14.6341 20.0218 14.6927L21.2013 15.8634C21.2308 15.8927 21.2603 15.9512 21.2603 15.9805C21.2603 16.0098 21.2603 16.0683 21.2013 16.0976L20.4641 16.8293L19.0782 15.4537L19.8154 14.722C19.8154 14.6341 19.8744 14.6341 19.9038 14.6341ZM14.95 22.2439H13.5641V20.8683L17.7808 16.6829L19.1667 18.0585L14.95 22.2439ZM9.14103 21.0732H4.42308C2.56538 21.0732 1.76923 20.2829 1.76923 18.439V4.39024C1.76923 2.54634 2.56538 1.7561 4.42308 1.7561H10.6154V4.39024C10.6154 7.22927 12.1782 8.78049 15.0385 8.78049H17.6923V10.2439C17.6923 10.7415 18.0756 11.122 18.5769 11.122C19.0782 11.122 19.4615 10.7415 19.4615 10.2439V7.90244C19.4615 7.66829 19.3731 7.43415 19.1962 7.2878L12.1192 0.263415C11.9718 0.0878049 11.7359 0 11.5 0H4.42308C1.56282 0 0 1.55122 0 4.39024V18.439C0 21.278 1.56282 22.8293 4.42308 22.8293H9.14103C9.64231 22.8293 10.0256 22.4488 10.0256 21.9512C10.0256 21.4537 9.64231 21.0732 9.14103 21.0732ZM12.3846 4.39024V2.98537L16.4538 7.02439H15.0385C13.1808 7.02439 12.3846 6.23415 12.3846 4.39024ZM5.60256 10.5366C5.10128 10.5366 4.71795 10.9171 4.71795 11.4146C4.71795 11.9122 5.10128 12.2927 5.60256 12.2927H13.859C14.3603 12.2927 14.7436 11.9122 14.7436 11.4146C14.7436 10.9171 14.3603 10.5366 13.859 10.5366H5.60256ZM10.3205 15.2195H5.60256C5.10128 15.2195 4.71795 15.6 4.71795 16.0976C4.71795 16.5951 5.10128 16.9756 5.60256 16.9756H10.3205C10.8218 16.9756 11.2051 16.5951 11.2051 16.0976C11.2051 15.6 10.8218 15.2195 10.3205 15.2195Z" fill="white"/>
                </svg>
                Daftar Usulan Project
              </a>
            </li>
            <li>
              <a href="{{ route('front.dashboard-daftar') }}" class="active">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M10.3902 20.093H5.02439C3.33415 20.093 2.60976 19.3395 2.60976 17.5814V4.18605C2.60976 2.42791 3.33415 1.67442 5.02439 1.67442H10.6585V4.18605C10.6585 6.89302 12.0805 8.37209 14.6829 8.37209H17.0976V10.8837C17.0976 11.3581 17.4463 11.7209 17.9024 11.7209C18.3585 11.7209 18.7073 11.3581 18.7073 10.8837V7.53488C18.7073 7.31163 18.6268 7.08837 18.4659 6.94884L12.0268 0.251163C11.8927 0.0837209 11.678 0 11.4634 0H5.02439C2.42195 0 1 1.47907 1 4.18605V17.5814C1 20.2884 2.42195 21.7674 5.02439 21.7674H10.3902C10.8463 21.7674 11.1951 21.4047 11.1951 20.9302C11.1951 20.4558 10.8463 20.093 10.3902 20.093ZM12.2683 4.18605V2.84651L15.9707 6.69767H14.6829C12.9927 6.69767 12.2683 5.94419 12.2683 4.18605ZM13.6098 10.0465C14.0659 10.0465 14.4146 10.4093 14.4146 10.8837C14.4146 11.3581 14.0659 11.7209 13.6098 11.7209H6.09756C5.64146 11.7209 5.29268 11.3581 5.29268 10.8837C5.29268 10.4093 5.64146 10.0465 6.09756 10.0465H13.6098ZM11.1951 15.3488C11.1951 15.8233 10.8463 16.186 10.3902 16.186H6.09756C5.64146 16.186 5.29268 15.8233 5.29268 15.3488C5.29268 14.8744 5.64146 14.5116 6.09756 14.5116H10.3902C10.8463 14.5116 11.1951 14.8744 11.1951 15.3488ZM17.9024 13.3953C15.0854 13.3953 12.8049 15.7674 12.8049 18.6977C12.8049 21.6279 15.0854 24 17.9024 24C20.7195 24 23 21.6279 23 18.6977C23 15.7674 20.7195 13.3953 17.9024 13.3953ZM17.9024 22.3256C15.9707 22.3256 14.4146 20.707 14.4146 18.6977C14.4146 16.6884 15.9707 15.0698 17.9024 15.0698C19.8341 15.0698 21.3902 16.6884 21.3902 18.6977C21.3902 20.707 19.8341 22.3256 17.9024 22.3256ZM19.8073 17.1628C20.1293 17.4977 20.1293 18.0279 19.8073 18.3349L18.0098 20.2047C17.8488 20.3721 17.661 20.4558 17.4463 20.4558C17.2317 20.4558 17.0171 20.3721 16.8829 20.2047L15.9976 19.2837C15.6756 18.9488 15.6756 18.4186 15.9976 18.1116C16.3195 17.7767 16.8293 17.7767 17.1244 18.1116L17.4463 18.4465L18.6537 17.1907C19.0024 16.8558 19.4854 16.8558 19.8073 17.1628Z" fill="white"/>
                </svg>
                Daftar Project
              </a>
            </li>
          </ul>
        </nav>
      </div>
      <div class="dashboard__right">
        <div class="dashboard__right--title">
          <h5>DAFTAR Project</h5>
        </div>
        <div class="box-white search">
          <div class="row">
            <div class="column column-50">
              <label for="">Nama Project</label>
              <input type="text" placeholder="Ketik Kata Kunci Pencarian">
            </div>
            <div class="column column-35">
              <label for="">Tahun</label>
              <select name="" id="">
                <option value="">Pilih Tahun</option>
              </select>
            </div>
            <div class="column column-15">
              <button type="submit" class="button-gradient button-icon button-large">
                Cari
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                  <path d="M7.33333 12.6667C10.2789 12.6667 12.6667 10.2789 12.6667 7.33333C12.6667 4.38781 10.2789 2 7.33333 2C4.38781 2 2 4.38781 2 7.33333C2 10.2789 4.38781 12.6667 7.33333 12.6667Z" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  <path d="M14.0992 13.7008L11.1992 10.8008" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
              </button>
            </div>
          </div>
        </div>
        <div class="box-white with-table">
          <h5>DAFTAR PROGRESS PROJECT</h5>
          <div class="content-pages">
            <div class="table-content">
              <table>
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nomor Project</th>
                    <th>Nama Project</th>
                    <th>Kategori</th>
                    <th>Tanggal Usulan</th>
                    <th>Tanggal Penyelesain</th>
                    <th>Status</th>
                    <th></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>A123766HG</td>
                    <td>Rancangan Peraturan Presiden</td>
                    <td>RUU</td>
                    <td>15 Juli 2025</td>
                    <td>24 Juli 2025</td>
                    <td><span class="status done">Selesai</span></td>
                    <td><a href="{{ route('front.dashboard-usulan-detail') }}" class="button button-outline">Detail</a></td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>A123766HG</td>
                    <td>Surat Edaran Menteri</td>
                    <td>Edaran</td>
                    <td>15 Juli 2025</td>
                    <td>24 Juli 2025</td>
                    <td><span class="status plan-1">Perencanaan</span></td>
                    <td><a href="{{ route('front.dashboard-usulan-detail') }}" class="button button-outline">Detail</a></td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>A123766HG</td>
                    <td>Rancangan Peraturan Presiden</td>
                    <td>RUU</td>
                    <td>15 Juli 2025</td>
                    <td>24 Juli 2025</td>
                    <td><span class="status plan-2">Perencanaan</span></td>
                    <td><a href="{{ route('front.dashboard-usulan-detail') }}" class="button button-outline">Detail</a></td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>A123766HG</td>
                    <td>Surat Edaran Menteri</td>
                    <td>Edaran</td>
                    <td>15 Juli 2025</td>
                    <td>24 Juli 2025</td>
                    <td><span class="status done">Selesai</span></td>
                    <td><a href="{{ route('front.dashboard-usulan-detail') }}" class="button button-outline">Detail</a></td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>A123766HG</td>
                    <td>Rancangan Peraturan Presiden</td>
                    <td>RUU</td>
                    <td>15 Juli 2025</td>
                    <td>24 Juli 2025</td>
                    <td><span class="status plan-1">Perencanaan</span></td>
                    <td><a href="{{ route('front.dashboard-usulan-detail') }}" class="button button-outline">Detail</a></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          @include ('static.component.pagination')
        </div>
      </div>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/dashboard.scss')}}" preload>
  @endpush
  @push('footer')
    <!-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script> -->
  @endpush
@endsection
