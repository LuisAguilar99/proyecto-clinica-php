$('a.nav-link').click(function() {
    var id = $(this).attr('id');
    switch (id) {
        case 'colapseClientes':
            $('#colapseClientes').addClass("active");
            $('#colapseUsuarios').removeClass("active");
            $('#colapseEmpleados').removeClass("active");
            $('#colapseCitas').removeClass("active");
            $('#colapseInicio').removeClass("active");
            $('#colapseEmpleados').attr('aria-expanded', "false");
            $('#colapseUsuarios').attr('aria-expanded', "false");
            $('#despleguerAccionesEmpleado').removeClass("show");
            $('#despleguerAccionesUsuario').removeClass("show");
            break;
        case 'colapseUsuarios':
            $('#colapseUsuarios').addClass("active");
            $('#colapseClientes').removeClass("active");
            $('#colapseEmpleados').removeClass("active");
            $('#colapseCitas').removeClass("active");
            $('#colapseInicio').removeClass("active");
            $('#colapseClientes').attr('aria-expanded', "false");
            $('#colapseEmpleados').attr('aria-expanded', "false");
            $('#despleguerAccionesEmpleado').removeClass("show");
            $('#despleguerAccionesCliente').removeClass("show");
            break;
        case 'colapseEmpleados':
            $('#colapseEmpleados').addClass("active");
            $('#colapseUsuarios').removeClass("active");
            $('#colapseClientes').removeClass("active");
            $('#colapseCitas').removeClass("active");
            $('#colapseInicio').removeClass("active");
            $('#colapseUsuarios').attr('aria-expanded', "false");
            $('#colapseClientes').attr('aria-expanded', "false");
            $('#despleguerAccionesCliente').removeClass("show");
            $('#despleguerAccionesUsuario').removeClass("show");
            break;
        case 'colapseInicio':
            $('#colapseInicio').addClass("active");
            $('#colapseUsuarios').removeClass("active");
            $('#colapseEmpleados').removeClass("active");
            $('#colapseCitas').removeClass("active");
            $('#colapseClientes').removeClass("active");
            break;
    }
});

function active() {
    $('#colapseCitas').addClass("active");
    $('#colapseUsuarios').removeClass("active");
    $('#colapseEmpleados').removeClass("active");
    $('#colapseClientes').removeClass("active");
    $('#colapseInicio').removeClass("active");
}