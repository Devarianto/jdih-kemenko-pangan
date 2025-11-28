<script>
    document.addEventListener("DOMContentLoaded", function () {
		const passwordInputs = document.querySelectorAll(".password-field");

		passwordInputs.forEach(input => {
			const wrapper = input.closest("div");
			const toggle = wrapper.querySelector(".toggle-password");
			const eye = toggle.querySelector(".icon-eye-off");
			const eyeOff = toggle.querySelector(".icon-eye");

			// Toggle by clicking the icon
			toggle.addEventListener("click", () => {
				if (input.type === "password") {
					input.type = "text";
					eye.style.display = "none";
					eyeOff.style.display = "block";
				} else {
					input.type = "password";
					eyeOff.style.display = "none";
					eye.style.display = "block";
				}
			});
		});
	});
</script>