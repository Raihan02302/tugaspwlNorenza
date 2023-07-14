  <style>
      .container {
          min-height: 100%;
          display: flex;
          flex-direction: column;
      }

      .content {
          flex: 1;
      }

      .footer {
          background-color: #e3f2fd;
          padding: 20px;
          text-align: center;
      }
  </style>
  <footer style="background-color: #e3f2fd;">
      <div class="container">
          Twitter Clone &copy; <?= date('Y') ?>
      </div>
  </footer>
  </div>
  <?= script_tag('js/bootstrap.bundle.min.js') ?>
  </body>

  </html>