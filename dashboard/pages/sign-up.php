<?php
require_once "../../proses/proses.php";
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Coffe Shop</title>
    <link
      rel="stylesheet"
      href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    />
    <link
      rel="stylesheet"
      href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-9/assets/css/login-9.css"
    />

    <style>
      .custom-section {
        background-color: #f5f5f5; /* Ganti dengan warna yang diinginkan */
      }
    </style>

    <section
      class="py-3 py-md-5 py-xl-8"
      style="
        background-image: url('../../image/home-bg.jpg');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
      "
    >
      <div class="container">
        <div class="row gy-4 align-items-center">
          <div class="col-12 col-md-6 col-xl-7">
            <div class="d-flex justify-content-center text-bg-primary">
              <style>
                .text-bg-primary {
                  background-image: url("../../image/book-bg.jpg");
                  background-size: cover;
                  background-position: center;
                  background-repeat: no-repeat;
                  font-size: 2.2rem;
                  color: var(--main-color);
                  line-height: 1.8;
                }
              </style>

              <div class="col-12 col-xl-9">
                <img
                  class="img-fluid rounded mb-4"
                  loading="lazy"
                  src="../../image/home-img-1.png"
                  width="245"
                  height="80"
                  alt="BootstrapBrain Logo"
                />
                <hr class="border-primary-subtle mb-4" />
                <h2 class="h1 mb-4">
                  We make digital products that drive you to stand out.
                </h2>

                <style>
                  h2 {
                    font-size: 2.2rem;
                    color: var(--main-color);
                    line-height: 1.8;
                  }
                </style>

                <p class="lead mb-5">what's make our coffee special!</p>

                <div class="text-endx">
                  <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="48"
                    height="48"
                    fill="currentColor"
                    class="bi bi-grip-horizontal"
                    viewBox="0 0 16 16"
                  >
                    <path
                      d="M2 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"
                    />
                  </svg>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 col-md-6 col-xl-5">
            <div class="card border-0 rounded-4">
              <div class="card-body p-3 p-md-4 p-xl-5">
                <div class="row">
                  <div class="col-12">
                    <div class="mb-4">
                      <h3>Sign up</h3>
                      <p>Do you have account? <a href="sign-in.php">Sign in</a></p>
                    </div>
                  </div>
                </div>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
                  <div class="row gy-3 overflow-hidden">
                    
                    <div style="margin-top: 1.5rem" class="col-13">
                      <div class="form-floating mb-3">
                        <input
                          type="text"
                          class="form-control"
                          name="nama"
                          id="nama"
                          placeholder="John Doe"
                          required
                        />
                        <label for="nama" class="form-label">Name</label>
                  </div>
                    
                       
                    <div class="col-12">
                      <div class="form-floating mb-3">
                        <input
                          type="email"
                          class="form-control"
                          name="email"
                          id="email"
                          placeholder="name@example.com"
                          required
                        />
                        <label for="email" class="form-label">Email</label>
                        
                        
                    </div>
                    <div class="col-12">
                      <div class="form-floating mb-3">
                        <input
                          type="password"
                          class="form-control"
                          name="password"
                          id="password"
                          value=""
                          placeholder="Password"
                          required
                        />
                        <label for="password" class="form-label"
                          >Password</label
                        >
                      </div>
                    </div>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-grid">
                        <button class="btn btn-primary btn-lg" type="submit" name="register">
                          Register
                        </button>
                      </div>
                    </div>
                  </div>
                </form>