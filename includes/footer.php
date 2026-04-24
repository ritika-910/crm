</main>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
 
function toggleSidebar() {
  $('#sidebar').toggleClass('open');
}

// User Dropdown 
function toggleUserMenu() {
  $('#userDropdown').toggleClass('show');
}
$(document).on('click', function(e) {
  if (!$(e.target).closest('.topbar-user').length) {
    $('#userDropdown').removeClass('show');
  }
});

// Ticket Accordion 
$(document).on('click', '.ticket-header', function() {
  var $body = $(this).next('.ticket-body');
  var $icon = $(this).find('.toggle-icon');
  $body.toggleClass('open');
  $icon.toggleClass('fa-chevron-down fa-chevron-up');
});

//  Auto hide alerts after 4 seconds 
setTimeout(function() {
  $('.alert').fadeOut(500);
}, 4000);

// Confirm delete
$(document).on('click', '.btn-delete-confirm', function(e) {
  if (!confirm('Are you sure you want to delete this?')) {
    e.preventDefault();
  }
});

//  Checkbox item highlight
$(document).on('change', '.checkbox-item input[type="checkbox"]', function() {
  $(this).closest('.checkbox-item').toggleClass('checked', this.checked);
});
</script>
</body>
</html>
