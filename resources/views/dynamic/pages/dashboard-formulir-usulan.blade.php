@extends('dynamic.layouts.layout')

@section('content')
  <section class="dashboard">
    <div class="wrapper">
      @include('dynamic.component.dashboard-left', ['active' => 'usulan'])
      <div class="dashboard__right">
        <div class="dashboard__right--title">
          <a href="{{ route('dashboard') }}" class="back">
            {{lang::translate('dashboard.kembali')}}
          </a>
        </div>
        <div class="box-white form">
          <form method="POST" action="{{ route('projects.store') }}" id="form-project" enctype="multipart/form-data">
            @csrf
            <div class="box-form">
              <h5>{{lang::translate('dashboard.usulan-project.formulir.title-form')}}</h5>
              <div class="row row-wrap">
                <div class="column column-100">
                  <label for="">{{lang::translate('dashboard.usulan-project.formulir.label-nomor-project')}}</label>
                  <input type="text" placeholder="{{lang::translate('dashboard.usulan-project.formulir.placeholder-nomor-project')}}" value="{{ old('no_project', 'Auto') }}" disabled>
                  <div class="supporting-text"></div>
                </div>
                <div class="column column-100 @error('name_project') error @enderror">
                  <label for="">{{lang::translate('dashboard.usulan-project.formulir.label-nama-project')}}<i>*</i></label>
                  <input type="text" class="required" maxlength="255" name="name_project" placeholder="{{lang::translate('dashboard.usulan-project.formulir.placeholder-nama-project')}}" value="{{ old('name_project') }}">
                  <div class="supporting-text"></div>
                </div>
                <div class="column column-50 @error('category_id') error @enderror">
                  <label for="">{{lang::translate('dashboard.usulan-project.formulir.label-kategori-project')}}<i>*</i></label>
                  <select name="category_id" id="" class="required" maxlength="255">
                    <option value="">{{lang::translate('dashboard.usulan-project.formulir.placeholder-kategori-project')}}</option>
                    @if(isset($categories))
                    @foreach($categories as $id => $label)
                    <option value="{{ $id }}" {{ old('category_id') == $id ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                    @endif
                  </select>
                  <div class="supporting-text"></div>
                </div>
                <div class="column column-50 @error('date') error @enderror">
                  <label for="">{{lang::translate('dashboard.usulan-project.formulir.label-tanggal-usulan')}}<i>*</i></label>
                  <input type="text" name="date" class="datepicker required" value="{{ old('date') }}" placeholder="{{lang::translate('dashboard.usulan-project.formulir.placeholder-tanggal-usulan')}}">
                  <div class="supporting-text"></div>
                </div>
                <div class="column column-100 @error('files.*') error @enderror">
                  <label for="">{{lang::translate('dashboard.usulan-project.formulir.label-dokumen-terlampir')}}<i>*</i></label>
                  <div class="file-upload">
                    <input type="file" name="files[]" class="required" id="fileUpload" @change="handleFileUpload" accept=".jpg,.png,.webp,.pdf,.doc,.docx" class="textfield-large" multiple>
                    <div class="text">
                      <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                        <path d="M35 25V31.6667C35 32.5507 34.6488 33.3986 34.0237 34.0237C33.3986 34.6488 32.5507 35 31.6667 35H8.33333C7.44928 35 6.60143 34.6488 5.97631 34.0237C5.35119 33.3986 5 32.5507 5 31.6667V25" stroke="#2063D2" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M28.3327 13.3333L19.9993 5L11.666 13.3333" stroke="#2063D2" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20 5V25" stroke="#2063D2" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                      <span>{{lang::translate('dashboard.usulan-project.formulir.placeholder-dokumen-terlampir')}}</span>
                      <small>{{lang::translate('dashboard.usulan-project.formulir.format-dokumen-terlampir')}}</small>
                    </div>
                    <span class="file-upload__box"></span>
                  </div>
                  <div id="fileList" class="file-list"></div>
                  <p id="fileError" style="color: red; margin-top: 8px;"></p>
                  <div class="supporting-text"></div>
                </div>
              </div>
              <hr>
              <h5>{{lang::translate('dashboard.usulan-project.formulir.title-pemohon')}}</h5>
              <div class="row row-wrap">
                <div class="column column-100 @error('applicant_divisions.*') error @enderror">
                  <label for="">{{lang::translate('dashboard.usulan-project.formulir.label-divisi-pemohon')}}</label>
                  <select class="select2" multiple="multiple" name="applicant_divisions[]">
                    @if(isset($applicantDivisions))
                    @foreach($applicantDivisions as $id => $label)
                    <option value="{{ $id }}" {{ collect(old('applicant_divisions', []))->contains($id) ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                    @endif
                  </select>
                  <div class="supporting-text"></div>
                </div>
                <div class="column column-100 @error('applicant_name') error @enderror">
                  <label for="">{{lang::translate('dashboard.usulan-project.formulir.label-nama-pemohon')}}<i>*</i></label>
                  <input type="text" name="applicant_name" class="required" maxlength="255" placeholder="{{lang::translate('dashboard.usulan-project.formulir.placeholder-nama-pemohon')}}" value="{{ old('applicant_name') }}">
                  <div class="supporting-text"></div>
                </div>
              </div>
            </div>
            <div class="wrap-btn">
              <a href="" class="button button-secondary">{{lang::translate('dashboard.usulan-project.formulir.button-cancel')}}</a>
              <button type="submit" class="button-gradient">{{lang::translate('dashboard.usulan-project.formulir.button-save')}}</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
  @push('head')
    <link rel="stylesheet" type="text/css" href="{{ Vite::asset('resources/assets/sass/pages/dashboard.scss')}}" preload>
    <style>
      button.is-disabled {
        background: grey !important;
        pointer-events: none;
      }
    </style>
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
          fileError.textContent = "{{lang::translate('dashboard.usulan-project.formulir.msg-error-dokumen-max-3')}}";
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
      
      window.addEventListener('load', function() {
        $('.datepicker').datepicker({
          autoclose: true,
          format: 'dd/mm/yyyy'
        });

        document.getElementById("form-project").addEventListener("submit", function (e) {
          let valid = true;
          const submitBtn = this.querySelector('button[type=submit]');
          submitBtn.textContent = "{{ lang::translate('dashboard.usulan-project.formulir.button-process') }}";
          submitBtn.disabled = true;
          submitBtn.classList.add("is-disabled");

          // ambil semua input di dalam form
          const inputs = this.querySelectorAll(".column input, .column select, .column textarea");
          inputs.forEach(input => {
            const parent = input.closest(".column");
            const msgBox = parent.querySelector(".supporting-text");

            // reset error terlebih dahulu
            parent.classList.remove("error-field");
            msgBox.textContent = "";

            const value = input.value.trim();

            // RULE: required
            if (input.classList.contains("required") && value === "") {
                parent.classList.add("error-field");
                msgBox.textContent = "{{ lang::translate('global.form-error.required') }}";
                valid = false;
                // return;
            }

            // RULE: email
            if (input.classList.contains("email") && value !== "" && !validateEmail(value)) {
                parent.classList.add("error-field");
                msgBox.textContent = "{{ lang::translate('global.form-error.email') }}";
                valid = false;
                // return;
            }

            // RULE: maxlength (baru)
            const max = input.getAttribute("maxlength");
            if (max && value.length > parseInt(max)) {
                parent.classList.add("error-field");
                msgBox.textContent = `{{ lang::translate('global.form-error.maxlength') }}`;
                msgBox.textContent = msgBox.textContent.replace(':max', max);
                valid = false;
                // return;
            }

            // RULE: minlength (baru)
            const min = input.getAttribute("minlength");
            if (min && value.length < parseInt(min)) {
                parent.classList.add("error-field");
                msgBox.textContent = `{{ lang::translate('global.form-error.minlength') }}`;
                msgBox.textContent = msgBox.textContent.replace(':min', min);
                valid = false;
                // return;
            }
          });

          const recaptchaField = document.querySelector("textarea[name='g-recaptcha-response']");
          if (recaptchaField) {
              const recaptchaValue = recaptchaField.value.trim();

              if (recaptchaValue === "") {
                  // tampilkan error recaptcha di bagian custom
                  const recaptchaContainer = document.querySelector(".recaptcha-container");
                  if (recaptchaContainer) {
                      recaptchaContainer.classList.add("error-field");

                      let msg = recaptchaContainer.querySelector(".supporting-text");
                      if (!msg) {
                          msg = document.createElement("div");
                          msg.classList.add("supporting-text");
                          recaptchaContainer.appendChild(msg);
                      }

                      msg.textContent = "{{ lang::translate('global.form-error.recaptcha') }}";
                  }

                  valid = false;
              }
          }

          // jika tidak valid, cegah submit
          if (!valid) {
            e.preventDefault();
            submitBtn.textContent = "{{ lang::translate('dashboard.usulan-project.formulir.button-kirim') }}";
            submitBtn.disabled = false;
            submitBtn.classList.remove("is-disabled");
          }
        });
      })
    </script>
  @endpush
@endsection
