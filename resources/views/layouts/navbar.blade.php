          <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
              id="layout-navbar">
              <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
                  <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                      <i class="ti ti-menu-2 ti-sm"></i>
                  </a>
              </div>

              <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                  <!-- Search -->
                  <h3 class="text-primary font-bold">Laundry Jacusa: <span class="text-muted">Jasa Cuci Esa</span></h3>
                  <!-- /Search -->

                  <ul class="navbar-nav flex-row align-items-center ms-auto">
                      <!-- Language -->

                      <!--/ Language -->

                      <!-- Style Switcher -->
                      <li class="nav-item me-2 me-xl-0">
                          <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                              <i class="ti ti-md"></i>
                          </a>
                      </li>
                      <!--/ Style Switcher -->

                      <!-- Quick links  -->

                      <!-- Quick links -->

                      <!-- Notification -->

                      <!--/ Notification -->

                      <!-- User -->
                      <li class="nav-item navbar-dropdown dropdown-user dropdown">
                          <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);"
                              data-bs-toggle="dropdown">
                              <div class="avatar avatar-online">
                                  <img src="{{ asset('assets/img/avatars/ESA.png') }}" alt
                                      class="h-auto rounded-circle" />
                              </div>
                          </a>
                          <ul class="dropdown-menu dropdown-menu-end">
                              <li>
                                  <a class="dropdown-item" href="pages-account-settings-account.html">
                                      <div class="d-flex">
                                          <div class="flex-shrink-0 me-3">
                                              <div class="avatar avatar-online">
                                                  <img src="{{ asset('assets/img/avatars/ESA.png') }}" alt
                                                      class="h-auto rounded-circle" />
                                              </div>
                                          </div>
                                          <div class="flex-grow-1">
                                              <span class="fw-semibold d-block">Esa Permana</span>
                                              <small class="text-muted">Kasir</small>
                                          </div>
                                      </div>
                                  </a>
                              </li>
                              <li>
                                  <div class="dropdown-divider"></div>
                              </li>
                              <li>
                                  <form id="logout-form" action="{{ route('proseslogout') }}" method="POST"
                                      style="display: none;">
                                      @csrf
                                  </form>
                                  <a class="dropdown-item" href="javascript:void(0);"
                                      onclick="konfirmasiLogout(event)">
                                      <i class="ti ti-logout me-2 ti-sm"></i>
                                      <span class="align-middle">Log Out</span>
                                  </a>
                              </li>
                          </ul>
                      </li>
                      <!--/ User -->
                  </ul>
              </div>

              <!-- Search Small Screens -->
              <div class="navbar-search-wrapper search-input-wrapper d-none">
                  <input type="text" class="form-control search-input container-xxl border-0"
                      placeholder="Search..." aria-label="Search..." />
                  <i class="ti ti-x ti-sm search-toggler cursor-pointer"></i>
              </div>
          </nav>
          <script>
              function konfirmasiLogout(event) {
                  event.preventDefault(); // Mencegah aksi default link

                  Swal.fire({
                      title: 'Apakah Anda yakin?',
                      text: "Sesi Anda akan diakhiri dan Anda harus login kembali.",
                      icon: 'warning',
                      showCancelButton: true,
                      confirmButtonColor: '#3085d6', // Warna tombol konfirmasi (bisa disesuaikan)
                      cancelButtonColor: '#d33', // Warna tombol batal
                      confirmButtonText: 'Ya, Logout!',
                      cancelButtonText: 'Batal',
                      customClass: {
                          confirmButton: 'btn btn-primary me-2',
                          cancelButton: 'btn btn-label-secondary'
                      },
                      buttonsStyling: false // Memaksa SweetAlert pakai styling tombol bawaan Vuexy/Bootstrap
                  }).then((result) => {
                      if (result.isConfirmed) {
                          // Jika user klik "Ya, Logout!", submit form logout-nya
                          document.getElementById('logout-form').submit();
                      }
                  });
              }
          </script>
