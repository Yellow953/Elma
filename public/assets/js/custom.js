// Form Controls
document.addEventListener('DOMContentLoaded', (event) => {
    const forms = document.querySelectorAll('form');

    forms.forEach(form => {
        // start disable multiple submit
        form.addEventListener('submit', function(event) {
            const submitButton = form.querySelector('[type="submit"]');

            if (submitButton) {
                submitButton.disabled = true;
            }
        });

        // Disable enter keypress
        form.addEventListener('keydown', function(event) {
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });

        // Handle reset button click
        const resetButton = form.querySelector('.reset-button');
        if (resetButton) {
            resetButton.addEventListener('click', function() {
                form.querySelectorAll('input, select').forEach(function(input) {
                    input.value = '';
                    if (input.tagName === 'SELECT') {
                        if ($(input).hasClass('select2')) {
                            $(input).val(null).trigger('change');
                        } else {
                            input.selectedIndex = 0;
                        }
                    }
                });
                form.submit();
            });
        }
    });
});
// end form control

// start delete confirmation
$(".show_confirm").click(function (event) {
    var form = $(this).closest("form");
    var name = $(this).data("name");
    event.preventDefault();
    swal({
        title: `Are you sure you want to delete this record?`,
        text: "If you delete this, it will be gone forever.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    }).then((willDelete) => {
        if (willDelete) {
            form.submit();
        }
    });
});
// end delete confirmation

// start jquery confirm
$(document).ready(function() {
    var formChanged = false;

    // Detect form changes
    $('form :input').on('change input', function() {
      formChanged = true;
    });

    // Prevent navigation if form is changed
  //   $(window).on('beforeunload', function() {
  //     if (formChanged) {
  //       return 'Warning: You have unsaved changes. Are you sure you want to leave?';
  //     }
  //   });

    $('form').on('submit', function() {
        formChanged = false;
    });

    // Handle link clicks
    $('a').on('click', function(event) {
      if ($(this).attr('target') !== '_blank' && this.href !== window.location.href && !$(this).hasClass('ignore-confirm') && formChanged ) {
        event.preventDefault();
       
        $.confirm({
          title: 'Unsaved Changes!',
          content: 'You have unsaved changes. Are you sure you want to leave?',
          buttons: {
            stay: {
              text: 'Stay',
              action: function() {
                // User chose to stay
              }
            },
            leave: {
              text: 'Leave',
              action: function() {
                window.location.href = event.target.href;
              }
            }
          }
        });
      }
    });

    // handle button clicks
    $('button').on('click', function(event) {
        if (!$(this).hasClass('ignore-confirm') && !$(this).is('[type="submit"]') && formChanged) {
            event.preventDefault();
            
            $.confirm({
                title: 'Unsaved Changes!',
                content: 'You have unsaved changes. Are you sure you want to leave?',
                buttons: {
                stay: {
                    text: 'Stay',
                    action: function() {
                    // User chose to stay
                    }
                },
                leave: {
                    text: 'Leave',
                    action: function() {
                    $(event.target).closest('form').submit();
                    }
                }
                }
            });
        }
    });
  });
// end jquery confirm

// start auto dismiss
document.addEventListener("DOMContentLoaded", function () {
    function addAutoDismiss(alert) {
        setTimeout(function () {
            alert.style.display = "none";
        }, 5000);
    }

    var autoDismissAlerts = document.querySelectorAll(".auto-dismiss");
    autoDismissAlerts.forEach(function (alert) {
        addAutoDismiss(alert);
    });

    document.body.addEventListener("DOMNodeInserted", function (event) {
        if (
            event.target.classList &&
            event.target.classList.contains("auto-dismiss")
        ) {
            addAutoDismiss(event.target);
        }
    });
});
// end auto dismiss

// start modal
function openModal(id) {
    var modal = $(`#${id}`);
    modal.show();

    modal.on("click", function (event) {
        if (event.target === this) {
            closeModal(id);
        }
    });
}

function closeModal(id) {
    var modal = $(`#${id}`);
    modal.hide();
    modal.off("click");
}
// end modal

var win = navigator.platform.indexOf("Win") > -1;
if (win && document.querySelector("#sidenav-scrollbar")) {
    var options = {
        damping: "0.5",
    };
    Scrollbar.init(document.querySelector("#sidenav-scrollbar"), options);
}

// start adjust sidenav scroll
document.addEventListener("DOMContentLoaded", function () {
    var activeElement = document.querySelector(".nav-link.active");

    if (activeElement) {
        var sidebar = document.getElementById("sidenav-main");
        var sidebarRect = sidebar.getBoundingClientRect();
        var elementRect = activeElement.getBoundingClientRect();

        var offset =
            elementRect.top -
            sidebarRect.top -
            (sidebarRect.height - elementRect.height) / 2;

        sidebar.scrollTo({ top: offset, behavior: "smooth" });
    }
});
//   end adjust sidenav scroll

// start select2
$(document).ready(function() {
    $('.select2').select2();
});
// end select2
