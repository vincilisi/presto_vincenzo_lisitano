<footer class="bg-body-tertiary text-center">
  <!-- Sezione: Lavora con noi -->
  <div class="col-md-5 offset-md-1 mb-3 text-center">
    <h5>{{ __('ui.footerReviewerTitle') }}</h5>
    <p>{{ __('ui.footerReviewerText') }}</p>
    <a href="{{ route('become.revisor') }}" class="btn btn-success">
      {{ __('ui.footerReviewerButton') }}
    </a>
  </div>

  <!-- Contenitore griglia -->
  <div class="container p-4 pb-0">
    <section class="mb-4">
      <a class="btn text-white btn-floating m-1" style="background-color: #3b5998;" role="button">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a class="btn text-white btn-floating m-1" style="background-color: #55acee;" href="#!" role="button">
        <i class="fab fa-twitter"></i>
      </a>
      <a class="btn text-white btn-floating m-1" style="background-color: #dd4b39;" href="#!" role="button">
        <i class="fab fa-google"></i>
      </a>
      <a class="btn text-white btn-floating m-1" style="background-color: #ac2bac;" href="#!" role="button">
        <i class="fab fa-instagram"></i>
      </a>
      <a class="btn text-white btn-floating m-1" style="background-color: #0082ca;" href="#!" role="button">
        <i class="fab fa-linkedin-in"></i>
      </a>
      <a class="btn text-white btn-floating m-1" style="background-color: #333333;" href="#!" role="button">
        <i class="fab fa-github"></i>
      </a>
    </section>
  </div>

  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.05);">
    © 2025 {{ __('ui.copyright') }}:
    <a class="text-body" href="">VinciWolf</a>
  </div>
</footer>
