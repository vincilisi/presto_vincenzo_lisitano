<footer class="text-center py-5">
  <!-- Sezione: Lavora con noi -->
  <div class="container">
    <div class="row justify-content-center mb-4">
      <div class="col-md-6 text-center">
        <h5>{{ __('ui.footerReviewerTitle') }}</h5>
        <p>{{ __('ui.footerReviewerText') }}</p>
        <a href="{{ route('become.revisor') }}" class="btn btn-success">
          {{ __('ui.footerReviewerButton') }}
        </a>
      </div>
    </div>

    <!-- Contenitore griglia social -->
    <div class="row justify-content-center mb-4">
      <div class="col-auto">
        <a class="btn text-white btn-floating m-1" style="background-color: #3b5998;" role="button">
          <i class="fab fa-facebook-f"></i>
        </a>
        <a class="btn text-white btn-floating m-1" style="background-color: #55acee;" role="button">
          <i class="fab fa-twitter"></i>
        </a>
        <a class="btn text-white btn-floating m-1" style="background-color: #dd4b39;" role="button">
          <i class="fab fa-google"></i>
        </a>
        <a class="btn text-white btn-floating m-1" style="background-color: #ac2bac;" role="button">
          <i class="fab fa-instagram"></i>
        </a>
        <a class="btn text-white btn-floating m-1" style="background-color: #0082ca;" role="button">
          <i class="fab fa-linkedin-in"></i>
        </a>
        <a class="btn text-white btn-floating m-1" style="background-color: #333333;" role="button">
          <i class="fab fa-github"></i>
        </a>
      </div>
    </div>

    <!-- Copyright -->
    <div class="text-center p-3">
      © 2025 {{ __('ui.copyright') }}:
      <a class="text-body" href="">Vincenzo Antonino Lisitano</a>
    </div>
  </div>
</footer>
