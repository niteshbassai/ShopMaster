// Form validation for adding/editing a product
document.addEventListener("DOMContentLoaded", function () {
    const productForm = document.querySelector("form");

    if (productForm) {
        productForm.addEventListener("submit", function (e) {
            const name = document.getElementById("name").value.trim();
            const description = document.getElementById("description").value.trim();
            const price = document.getElementById("price").value.trim();
            const categoryId = document.getElementById("category_id").value.trim();
            const image = document.getElementById("image").files.length;

            // Basic validation for required fields
            if (name === "" || description === "" || price === "" || categoryId === "") {
                e.preventDefault();
                alert("Please fill in all the required fields.");
                return false;
            }

            // Validate price to be a valid number
            if (isNaN(price) || price <= 0) {
                e.preventDefault();
                alert("Please enter a valid price.");
                return false;
            }

            // Ensure an image is uploaded (for add product)
            if (image === 0 && !document.querySelector("[name='current_image']")) {
                e.preventDefault();
                alert("Please upload a product image.");
                return false;
            }

            // If all validations pass, submit the form
            return true;
        });
    }
});

// Confirmation for product deletion
const deleteLinks = document.querySelectorAll('.delete-link');

deleteLinks.forEach(link => {
    link.addEventListener('click', function (e) {
        const confirmed = confirm('Are you sure you want to delete this product?');
        if (!confirmed) {
            e.preventDefault(); // Prevent the delete action if the user cancels
        }
    });
});
