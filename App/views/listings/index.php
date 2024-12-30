
<?php
    loadComponent("header");
?>
  <body class="bg-gray-100">
    <!-- Header -->
    <header class="bg-blue-900 text-white p-4">
      <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-3xl font-semibold">
          <a href="index.html">Workopia</a>
        </h1>
        <nav class="space-x-4">
          <a href="login.html" class="text-white hover:underline">Login</a>
          <a href="register.html" class="text-white hover:underline">Register</a>
          <a
            href="post-job.html"
            class="bg-yellow-500 hover:bg-yellow-600 text-black px-4 py-2 rounded hover:shadow-md transition duration-300"
            ><i class="fa fa-edit"></i> Post a Job</a
          >
        </nav>
      </div>
    </header>

    <!-- Top Banner -->
    <section class="bg-blue-900 text-white py-6 text-center">
      <div class="container mx-auto">
        <h2 class="text-3xl font-semibold">Unlock Your Career Potential</h2>
        <p class="text-lg mt-2">
          Discover the perfect job opportunity for you.
        </p>
      </div>
    </section>

    <!-- Job Listings -->
    <section>
      <div class="container mx-auto p-4 mt-4">
        <div class="text-center text-3xl mb-4 font-bold border border-gray-300 p-3">All Jobs</div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <?php
          foreach ($listings as $key => $value) {
            echo '
            <div class="rounded-lg shadow-md bg-white">
              <div class="p-4">
                <h2 class="text-xl font-semibold">' . $value['title'] . '</h2>
                <p class="text-gray-700 text-lg mt-2">
                  '.$value['description'].'
                  high-quality software solutions.
                </p>
                <ul class="my-4 bg-gray-100 p-4 rounded">
                  <li class="mb-2"><strong>Salary:</strong> $' . $value['salary'] . '</li>
                  <li class="mb-2">
                    <strong>Location:</strong> ' . $value['city'] . '
                    <span
                      class="text-xs bg-blue-500 text-white rounded-full px-2 py-1 ml-2"
                      >Local</span
                    >
                  </li>
                  <li class="mb-2">
                    <strong>Tags:</strong> <span>' . $value['tags'] . '</span>,
                  </li>
                </ul>
                <a href="listing/show?id='.$value['id'].'"
                  class="block w-full text-center px-5 py-2.5 shadow-sm rounded border text-base font-medium text-indigo-700 bg-indigo-100 hover:bg-indigo-200"
                >
                  Details
                </a>
              </div>
          </div>';

            }
          ?>
        </div>
      </div>
      </section>
<?php
    loadComponent("bottom_banner");
    loadComponent("footer");
?>
