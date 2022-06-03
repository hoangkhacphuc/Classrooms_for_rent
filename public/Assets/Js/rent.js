$(document).ready(function () {
    let change_choose_room = true;
    $('#room_rent').change(function (e) { 
        e.preventDefault();
        change_choose_room = true;
    });

    $('#date_rent').change(function (e) { 
        e.preventDefault();
        change_choose_room = true;
    });


  $("#btn-search").click(function () {
    // get the value of the input room_rent, date_rent
    var room_rent = $("#room_rent").val();
    var date_rent = $("#date_rent").val();
    // check if the value is empty or not
    if (room_rent == "" || date_rent == "") {
      // if the value is empty, show the error message
      // swal will show the error message
      swal("Cảnh báo!", "Vui lòng nhập đầy đủ thông tin", "error");
      return;
    }

    change_choose_room = false;
    // post the value to ./api/getListShiftRent
    $.post(
      "./api/getListShiftRent",
      {
        room: room_rent,
        date: date_rent,
      },
      function (data) {
        data = JSON.parse(data);
        if (data.status == "success") {
          swal("Thông báo!", data.message, "success");
          for (let i = 0; i < $("#tr-list-btn>td").length; i++) {
            $("#tr-list-btn>td").eq(i).children("button").addClass("btn-info");
            $("#tr-list-btn>td")
              .eq(i)
              .children("button")
              .removeClass("btn-success");
            $("#tr-list-btn>td")
              .eq(i)
              .children("button")
              .attr("data-select", "0");
          }
          for (let i = 0; i < data.data.length; i++) {
            const item = data.data[i];
            $("#shift_" + item.shift_id).removeClass("btn-info");
            $("#shift_" + item.shift_id).attr("data-select", "-1");
          }

          return;
        }
        swal("Cảnh báo!", data.message, "error");
      }
    );
  });

  $("#tr-list-btn>td>button").click(function () {
    let select = $(this).attr("data-select");
    if (select == "0") {
      $(this).addClass("btn-success");
      $(this).removeClass("btn-info");
      $(this).attr("data-select", "1");
    } else if (select == "1") {
      $(this).removeClass("btn-success");
      $(this).addClass("btn-info");
      $(this).attr("data-select", "0");
    }
  });

  $("#t-room_rent>tr>td>button.btn-danger").click(function () {
    let id = $(this).attr("data-id");
    // post the value to ./api/deleteRoomRent
    $.post(
      "./api/deleteRoomRent",
      {
        id: id,
      },
      function (data) {
        data = JSON.parse(data);
        if (data.status == "success") {
          swal("Thông báo!", data.message, "success");
          location.reload();
        } else {
          swal("Cảnh báo!", data.message, "error");
        }
      }
    );
  });


  $('#btn-rent').click(function (e) { 
      e.preventDefault();
      if (change_choose_room == true) {
        swal("Cảnh báo!", "Vui lòng chọn phòng, ngày thuê và tìm ca lại", "error");
        return;
      }
        let list_select = [];
        for (let i = 0; i < $("#tr-list-btn>td").length; i++) {
            if ($("#tr-list-btn>td").eq(i).children("button").attr("data-select") == "1") {
                list_select.push($("#tr-list-btn>td").eq(i).children("button").attr("data-id"));
            }
        }
        if (list_select.length == 0) {
            swal("Cảnh báo!", "Vui lòng chọn ca thuê", "error");
            return;
        }
        let room_id = $('#room_rent').val();
        let date_rent = $('#date_rent').val();
        if (room_rent == "" || date_rent == "") {
            // if the value is empty, show the error message
            // swal will show the error message
            swal("Cảnh báo!", "Vui lòng nhập đầy đủ thông tin", "error");
            return;
        }

        // post the value to ./api/rentRoom
        $.post("./api/rentRoom", {
            room_id: room_id,
            date_hire: date_rent,
            rent_shift: list_select
        }, function (data) {
            data = JSON.parse(data);
            if (data.status == "success") {
                swal("Thông báo!", data.message, "success");
                setTimeout(function () {
                    location.reload();
                }, 1000);
            } else {
                swal("Cảnh báo!", data.message, "error");
            }
        });
  });
});
