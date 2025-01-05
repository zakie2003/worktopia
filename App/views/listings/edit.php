<?php
    loadComponent("header");
?>
  <body class="bg-gray-100">
    <?php
    loadComponent("nav");
    ?>

    <!-- Post a Job Form Box -->
    <section class="flex justify-center items-center mt-20">
      <div class="bg-white p-8 rounded-lg shadow-md w-full md:w-600 mx-6">
        <h2 class="text-4xl text-center font-bold mb-4">Edit Job Listing</h2>
        <!-- <div class="message bg-red-100 p-3 my-3">This is an error message.</div>
        <div class="message bg-green-100 p-3 my-3">
          This is a success message.
        </div> -->
        <form method="POST" action="/listing/update/<?= $newListing["id"]?>">
            <input type="hidden" name="id" value="<?=$newListing['id'] ?? ""; ?>"/>
          <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
            Job Info
          </h2>
          <?php if (isset($errors)) {
            foreach ($errors as $key => $value) {
              echo '<div class="message bg-red-100 p-3 my-3">' . $value . '</div>';
            }
          }
          ?>
          <div class="mb-4">
            <input
              type="text"
              name="title"
              placeholder="Job Title"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['title'] ?? ""; ?>"
            />
          </div>
          <div class="mb-4">
            <textarea
              name="description"
              placeholder="Job Description"
              class="w-full px-4 py-2 border rounded focus:outline-none"><?=$newListing['description'] ?? ""; ?></textarea>
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="salary"
              placeholder="Annual Salary"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['salary'] ?? ""; ?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="requirements"
              placeholder="Requirements"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['requirements'] ?? ""; ?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="benefits"
              placeholder="Benefits"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['benefits'] ?? ""; ?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="tags"
              placeholder="Tags"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['tags'] ?? ""; ?>"
            />
          </div>
          <h2 class="text-2xl font-bold mb-6 text-center text-gray-500">
            Company Info & Location
          </h2>
          <div class="mb-4">
            <input
              type="text"
              name="company"
              placeholder="Company Name"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['company'] ?? ""; ?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="address"
              placeholder="Address"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['address'] ?? ""; ?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="city"
              placeholder="City"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['city'] ?? ""; ?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="state"
              placeholder="State"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['state'] ?? ""; ?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="text"
              name="phone"
              placeholder="Phone"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['phone'] ?? ""; ?>"
            />
          </div>
          <div class="mb-4">
            <input
              type="email"
              name="email"
              placeholder="Email Address For Applications"
              class="w-full px-4 py-2 border rounded focus:outline-none"
              value="<?=$newListing['email'] ?? ""; ?>"
            />
          </div>
          <button type="submit"
            class="w-full bg-green-500 hover:bg-green-600 text-white px-4 py-2 my-3 rounded focus:outline-none"
          >
            Save
          </button>
          <a
            href="/listing"
            class="block text-center w-full bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded focus:outline-none"
          >
            Cancel
          </a>
        </form>
      </div>
    </section>


<?php
  loadComponent("bottom_banner");
  loadComponent("footer");
?>