@extends('dynamic.layouts.layout')

@section('content')
  <section class="dashboard">
    <div class="wrapper">
      @include('dynamic.component.dashboard-left', ['active' => 'usulan'])
      <div class="dashboard__right">
        <div class="dashboard__right--title">
          <a href="{{ route('dashboard') }}" class="back">
            Kembali
          </a>
        </div>
        <div class="box-white form">
          @if ($errors->any())
          <div class="alert alert-danger" style="margin-bottom:16px;">
            <ul style="margin:0; padding-left:18px;">
              @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
          @endif
          <form method="POST" action="{{ route('projects.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="box-form">
              <h5>Formulir USULAN PROJECT</h5>
              <div class="row row-wrap">
                <div class="column column-100">
                  <label for="">Nomor Project</label>
                  <input type="text" name="no_project" placeholder="Ketik Nomor Project" value="{{ old('no_project') }}">
                </div>
                <div class="column column-100">
                  <label for="">Nama Project</label>
                  <input type="text" name="name_project" placeholder="Ketik Nama Project" value="{{ old('name_project') }}">
                </div>
                <div class="column column-50">
                  <label for="">Kategori</label>
                  <select name="category_id" id="">
                    <option value="">Pilih Kategori</option>
                    @if(isset($categories))
                    @foreach($categories as $id => $label)
                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="column column-50">
                  <label for="">Tanggal Usulan</label>
                  <input type="date" name="date" class="datepicker" value="{{ old('date') }}">
                </div>
               <div class="column column-100">
                 <label for="">Dokumen Terlampir</label>
                  <div class="file-upload">
                    <input type="file" name="files[]" id="fileUpload" @change="handleFileUpload" accept=".jpg,.png,.webp,.pdf,.doc,.docx" class="textfield-large" multiple>
                    <div class="text">
                      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M35 25V31.6667C35 32.5507 34.6488 33.3986 34.0237 34.0237C33.3986 34.6488 32.5507 35 31.6667 35H8.33333C7.44928 35 6.60143 34.6488 5.97631 34.0237C5.35119 33.3986 5 32.5507 5 31.6667V25" stroke="#2063D2" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M28.3327 13.3333L19.9993 5L11.666 13.3333" stroke="#2063D2" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 5V25" stroke="#2063D2" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                      <span>Select a file to upload</span>
                      <small>PDF/DOC format, Max 5MB</small>
                    </div>
                    <span class="file-upload__box"></span>
                  </div>
                  <div id="fileList" class="file-list"></div>
                  <p id="fileError" style="color: red; margin-top: 8px;"></p>
                </div>
              </div>
              <hr>
              <h5>Informasi Pemohon</h5>
              <div class="row row-wrap">
                <div class="column column-100">
                  <label for="">Divisi/Pemohon Terkait</label>
                  <select class="select2" multiple="multiple" name="applicant_divisions[]">
                    @if(isset($applicantDivisions))
                    @foreach($applicantDivisions as $id => $label)
                    <option value="{{ $id }}" {{ collect(old('applicant_divisions', []))->contains($id) ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                    @endif
                  </select>
                </div>
                <div class="column column-100">
                  <label for="">Nama Pemohon</label>
                  <input type="text" name="applicant_name" placeholder="Nama Lengkap" value="{{ old('applicant_name') }}">
                </div>
              </div>
            </div>
            <div class="wrap-btn">
              <a href="" class="button button-secondary">Batalkan</a>
              <button type="submit" class="button-gradient">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/dashboard.scss')}}" preload>
  @endpush
  @push('footer')
    <!-- <script type="module" async type="text/javascript" src="{{ Vite::asset('resources/assets/js/document.js') }}"></script> -->
    <script>
      let selectedFiles = [];
      document.getElementById("fileUpload").addEventListener("change", function(event) {
        const input = document.getElementById("fileUpload");
        const fileList = document.getElementById("fileList");
        const fileError = document.getElementById("fileError");

        // Merge existing selected files with newly chosen files (avoid duplicates by name+size+lastModified)
        const newlyChosen = Array.from(input.files);
        newlyChosen.forEach((file) => {
          if (!selectedFiles.find(f => f.name === file.name && f.size === file.size && f.lastModified === file.lastModified)) {
            selectedFiles.push(file);
          }
        });

        // Enforce max 3 files
        if (selectedFiles.length > 3) {
          fileError.textContent = "Maksimal 3 file dapat diunggah.";
          selectedFiles = selectedFiles.slice(0, 3);
        } else {
          fileError.textContent = "";
        }

        // Rebuild input.files with DataTransfer from selectedFiles
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        input.files = dt.files;

        // Rebuild UI list from input.files
        fileList.innerHTML = "";
        Array.from(input.files).forEach((file) => {
          const listItem = document.createElement("div");
          listItem.classList.add("file-item");
          listItem.setAttribute("data-filename", file.name);
          listItem.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M3.8335 3.91211V15.5787C3.8335 16.9595 4.95279 18.0787 6.3335 18.0787H14.6668C16.0476 18.0787 17.1668 16.9595 17.1668 15.5787V7.24544C17.1668 5.86473 16.0476 4.74544 14.6668 4.74544H4.66683C4.2066 4.74544 3.8335 4.37234 3.8335 3.91211ZM6.54183 9.74541C6.54183 9.40024 6.82165 9.12041 7.16683 9.12041H13.8335C14.1787 9.12041 14.4585 9.40024 14.4585 9.74541C14.4585 10.0906 14.1787 10.3704 13.8335 10.3704H7.16683C6.82165 10.3704 6.54183 10.0906 6.54183 9.74541ZM6.54183 12.6621C6.54183 12.3169 6.82165 12.0371 7.16683 12.0371H11.7502C12.0953 12.0371 12.3752 12.3169 12.3752 12.6621C12.3752 13.0072 12.0953 13.2871 11.7502 13.2871H7.16683C6.82165 13.2871 6.54183 13.0072 6.54183 12.6621Z" fill="#292EC6"/>
              <path opacity="0.5" d="M15.5002 3.33397V4.88786C15.2395 4.79573 14.959 4.74561 14.6668 4.74561H4.66683C4.2066 4.74561 3.8335 4.37251 3.8335 3.91227V3.85307C3.8335 3.40888 4.1601 3.0323 4.59982 2.96948L13.5978 1.68406C14.6018 1.54062 15.5002 2.31972 15.5002 3.33397Z" fill="#292EC6"/>
            </svg>
            <span>${file.name}</span>
            <div class="remove-btn">
              <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                <path d="M16.3048 4.19523C16.0445 3.93492 15.6224 3.93492 15.3621 4.19523L10.5 9.05736L5.63789 4.19523C5.37758 3.93492 4.95554 3.93492 4.69523 4.19523C4.43492 4.45554 4.43492 4.87758 4.69523 5.13788L9.55735 10L4.69525 14.8621C4.43494 15.1224 4.43494 15.5444 4.69525 15.8048C4.95555 16.0651 5.3776 16.0651 5.6379 15.8048L10.5 10.9426L15.3621 15.8048C15.6224 16.0651 16.0445 16.0651 16.3048 15.8048C16.5651 15.5444 16.5651 15.1224 16.3048 14.8621L11.4426 10L16.3048 5.13788C16.5651 4.87758 16.5651 4.45554 16.3048 4.19523Z" fill="#0F0F0F"/>
              </svg>
            </div>
          `;
          fileList.appendChild(listItem);
        });
      });

      // Event listener untuk tombol hapus berdasarkan nama file
      document.getElementById("fileList").addEventListener("click", function(event) {
        const removeBtn = event.target.closest(".remove-btn");
        if (removeBtn) {
          const listItem = removeBtn.parentElement;
          const fileNameToRemove = listItem.getAttribute("data-filename");
          const input = document.getElementById("fileUpload");
          // Update selectedFiles cache
          selectedFiles = selectedFiles.filter(f => f.name !== fileNameToRemove);
          // Rebuild input files
          const dt = new DataTransfer();
          selectedFiles.forEach(file => dt.items.add(file));
          input.files = dt.files;
          // Remove UI element
          listItem.remove();
          // Clear error if under limit
          const fileError = document.getElementById("fileError");
          if (selectedFiles.length <= 3) {
            fileError.textContent = "";
          }
        }
      });
    </script>
  @endpush
@endsection
