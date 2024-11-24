<?php
require '../admin/aheader.php';
?>
            <div class="page-header">
              <h3 class="fw-bold mb-3">Forms</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="#">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Forms</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#">Basic Form</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="card-title">Judul Form</div>
                  </div>
                  <div class="card-body">
                    <div class="row">
                      
                      <div class="col-md-6 col-lg-4">
                        
                        

                        <div class="form-group">
                          <label for="largeInput">Nama</label>
                          <input
                            type="text"
                            class="form-control form-control"
                            id="defaultInput"
                            placeholder="Default Input"
                          />
                        </div>
                        <div class="form-group">
                          <label for="defaultSelect">Pilihan</label>
                          <select
                            class="form-select form-control"
                            id="defaultSelect"
                          >
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                          </select>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-action">
                    <button class="btn btn-success">Submit</button>
                  </div>
                </div>
              </div>
            </div>

<?php
require '../admin/afooter.php';
?>
