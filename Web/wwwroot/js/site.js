var ipserver = "192.168.0.16";

$(document).ready(() => {

    let hhref = window.location.pathname;

    checkUCookie($.cookie('UCookie'));

    function checkUCookie(temp_UCookie) {
        $.ajax({
            url: `http://${ipserver}/Users/login.php?check=${temp_UCookie}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $.cookie('UStatus', '1', { path: '/' });
            },
            error: function (xhr, status, error) {
                $.cookie('UStatus', '0', { path: '/' });
            }
        })
    }

    if ($.cookie('UStatus') == 1) {
        $('.navbar-nav').append(`<li class="nav-item"><button id="exit" class="btn btn-primary">Выйти</button></li>`);
    } else {
        $('#exit').remove();
    }

    $('#exit').on('click', () => {
        $.removeCookie('UCookie', {path: '/'});
        $.removeCookie('UStart', { path: '/' });
        window.location.replace("/Home");
        $('#exit').remove();
    });

    if (hhref == "/Home/Login") {
        console.log("Страница авторизации");

        if ($.cookie('UStatus') == 1) {
            window.location.replace("/Home/Visits");
        }

    } else if (hhref == "/Home/Visits" || hhref == "/Home/Public_Visit" || hhref == "/Home/Personal_Visit") {
        console.log("Страница визитов");

        if ($.cookie('UStatus') == 0) {
            window.location.replace("/Home/Login");
        }
    }
});

// Функция отправки формы регистрации
$("#_auth_form #_reg_button").on('click', () => {
    var email = $("#_auth_form #email");
    var password = $("#_auth_form #password");

    if (!email.val() || !password.val()) {
        _toast("error", "Не все поля заполнены!");
    } else {

        $.ajax({
            url: `http://${ipserver}/Users/reg.php?email=${email.val()}&password=${password.val() }`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                if (data == 1) {
                    _toast("success", "Аккаунт зарегистрирован!");
                } else {
                    _toast("error", "Такой пользователь есть!");
                }
            },
            error: function (xhr, status, error) {
            }
        })
    }
})
// Функция отправки формы авторизации
$("#_auth_form #_auth_button").on('click', () => {
    var email = $("#_auth_form #email");
    var password = $("#_auth_form #password");

    if (!email.val() || !password.val()) {
        _toast("error", "Не все поля заполнены!");
    } else {

        $.ajax({
            url: `http://${ipserver}/Users/login.php?email=${email.val()}&password=${password.val() }`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                console.log(data);

                if (data != 0) {

                    $.cookie('UCookie', data, { path: '/' });
                    window.location.replace("/Home/Visits");
                    _toast("success", "Вы успешно вошли!");

                } else {
                    _toast("error", "Не верный логин или пароль!");
                }
            },
            error: function (xhr, status, error) {
            }
        })

    }
})

// Заполнение подразделения
if ($("#_Division")) {
    $.ajax({
        url: `http://${ipserver}/Staff/Divisions.php`,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            let i = 0;
            while (data.length) {
                $("#_Division").append(`<option value="${data[i]["division"]}">${data[i]["division"]}</option>`);
                i++;
            }
        },
        error: function (xhr, status, error) {
        }
    })

    $("#_Division").change(() => {
        let divis = $('#_Division').val();
        $.ajax({
            url: `http://${ipserver}/Staff/byStaff.php?division=${divis}`,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                $("#_fio option").remove();
                let i = 0;
                while (data.length) {
                    $("#_fio").append(`<option value="${data[i]["id"]}">${data[i]["f_name"]} ${data[i]["i_name"]} ${data[i]["o_name"]}</option>`);
                    i++;
                }
            },
            error: function (xhr, status, error) {
            }
        })
    })
}

// Отправка заявки личного посещения
$("#_Personal_Visit #send").on('click', () => {

    var Visit = {};

    let _s_date = $("#_Personal_Visit #_s_date");
    let _po_date = $("#_Personal_Visit #_po_date");
    let _purpose = $("#_Personal_Visit #_purpose");
    let _Division = $("#_Personal_Visit #_Division");
    let _fio = $("#_Personal_Visit #_fio");

    let _f_name = $("#_Personal_Visit #_f_name");
    let _n_name = $("#_Personal_Visit #_n_name");
    let _o_name = $("#_Personal_Visit #_o_name");
    let _tel = $("#_Personal_Visit #_tel");
    let _email = $("#_Personal_Visit #email");
    let _organization = $("#_Personal_Visit #_organization");
    let _node = $("#_Personal_Visit #_node");
    let _date_age = $("#_Personal_Visit #_date_age");
    let _ser_passport = $("#_Personal_Visit #_ser_passport");
    let _num_passport = $("#_Personal_Visit #_num_passport");


    if (!_s_date.val() || !_po_date.val() || !_purpose.val() || !_Division.val() || !_fio.val() || !_f_name.val() || !_n_name.val() || !_tel.val()
        || !_organization.val() || !_node.val() || !_date_age.val() || !_ser_passport.val() || !_num_passport.val()) {

        _toast("error", "Не все поля заполнены!");

    } else {

        Visit['_s_date'] = _s_date.val();
        Visit['_po_date'] = _po_date.val();
        Visit['_purpose'] = _purpose.val();
        Visit['_Division'] = _Division.val();
        Visit['_fio'] = _fio.val();
        Visit['_f_name'] = _f_name.val();
        Visit['_n_name'] = _n_name.val();
        Visit['_o_name'] = _o_name.val();
        Visit['_tel'] = _tel.val();
        Visit['_email'] = _email.val();
        Visit['_organization'] = _organization.val();
        Visit['_node'] = _node.val();
        Visit['_date_age'] = _date_age.val();
        Visit['_ser_passport'] = _ser_passport.val();
        Visit['_num_passport'] = _num_passport.val();

        $.ajax({
            url: `http://${ipserver}/Visits/add.php`,
            type: 'POST',
            dataType: 'json',
            data: Visit,
            success: function (data) {
                
            },
            error: function (xhr, status, error) {
            }
        })

        _f_name.val('');
        _n_name.val('');
        _o_name.val('');
        _tel.val('');
        _email.val('');
        _organization.val('');
        _node.val('');
        _date_age.val('');
        _ser_passport.val('');
        _num_passport.val('');

        console.log("В базу добавлен висит");

        _toast("success", "Заявка отправлена");
    }
})

// Отправка заявки публичного посещения
$("#_Public_Visit #send").on('click', () => {
    if (Object.keys(PVisits).length < 1) {
        _toast("error", "Пользователей доблжно быть минимум 5");
    } else {
        var jsonData = JSON.stringify(PVisits);
        $.ajax({
            url: `http://${ipserver}/Visits/add_more.php`,
            type: 'POST',
            dataType: 'json',
            data: {
                json_data: jsonData
            },
            success: function (data) {
                console.log(data);
            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        })

        _toast("success", "Заявка отправлена");

        // Очистка массива PVisits

        Object.keys(PVisits).forEach(function (key) {
            delete PVisits[key];
        });

        $("#_Public_Visit #t_content").remove();

    }

})
// Добавление пользователя в список визитов

function PVisiter(_s_date, _po_date, _purpose, _Division, _fio, _f_name, _n_name, _o_name, _tel, _email, _organization, _node, _date_age, _ser_passport, _num_passport) {
    this._s_date = _s_date;
    this._po_date = _po_date;
    this._purpose = _purpose;
    this._Division = _Division;
    this._fio = _fio;
    this._f_name = _f_name;
    this._n_name = _n_name;
    this._o_name = _o_name;
    this._tel = _tel;
    this._email = _email;
    this._organization = _organization;
    this._node = _node;
    this._date_age = _date_age;
    this._ser_passport = _ser_passport;
    this._num_passport = _num_passport;
}

var PVisits = {};
let t_p_v_s = 1;
$("#_Public_Visit #add").on('click', () => {

    var PVisitsLen = Object.keys(PVisits).length;

    let _s_date = $("#_Public_Visit #_s_date");
    let _po_date = $("#_Public_Visit #_po_date");
    let _purpose = $("#_Public_Visit #_purpose");
    let _Division = $("#_Public_Visit #_Division");
    let _fio = $("#_Public_Visit #_fio");

    let _f_name = $("#_Public_Visit #_f_name");
    let _n_name = $("#_Public_Visit #_n_name");
    let _o_name = $("#_Public_Visit #_o_name");
    let _tel = $("#_Public_Visit #_tel");
    let _email = $("#_Public_Visit #email");
    let _organization = $("#_Public_Visit #_organization");
    let _node = $("#_Public_Visit #_node");
    let _date_age = $("#_Public_Visit #_date_age");
    let _ser_passport = $("#_Public_Visit #_ser_passport");
    let _num_passport = $("#_Public_Visit #_num_passport");

    if (!_s_date.val() || !_po_date.val() || !_purpose.val() || !_Division.val() || !_fio.val() || !_f_name.val() || !_n_name.val() || !_tel.val()
        || !_organization.val() || !_node.val() || !_date_age.val() || !_ser_passport.val() || !_num_passport.val()) {

        _toast("error", "Не все поля заполнены!");

    } else {
        PVisits[PVisitsLen] = (new PVisiter(_s_date.val(), _po_date.val(), _purpose.val(), _Division.val(), _fio.val(), _f_name.val(), _n_name.val(), _o_name.val(), _tel.val(), _email.val(), _organization.val(), _node.val(), _date_age.val(), _ser_passport.val(), _num_passport.val()));

        $("#_Public_Visit #t_content").append(`<tr>
                        <th scope="row" id="id_`+ t_p_v_s + `">` + t_p_v_s + `</th>
                        <td>` + _f_name.val() + " " + _n_name.val() + " " + _o_name.val() + `</td>
                        <td>` + _tel.val() + `</td>
                    </tr>`);
        t_p_v_s++;

        _f_name.val('');
        _n_name.val('');
        _o_name.val('');
        _tel.val('');
        _email.val('');
        _organization.val('');
        _node.val('');
        _date_age.val('');
        _ser_passport.val('');
        _num_passport.val('');

        _toast("success", "Пользователь добавлен!");

        console.log(PVisits);
    }
});

    function _toast(type, text) {
        switch (type) {
            case "error":
                toastr[type](text, "Ошибка")
                break;
            case "success":
                toastr[type](text, "Успешно")
                break;
        }
    }

    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "5000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

