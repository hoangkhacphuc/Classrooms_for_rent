$(document).ready(function () {
    $(document).on('click', '.btn-delete-room', function (e) { 
        e.preventDefault();
        let id = $(this).attr('data-id');
        swal({
            title: "Bạn chắc chắn chứ?",
            text: "Khi xóa phòng, thông tin phòng đã cho thuê cũng sẽ xóa!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
                $.post("./admin/api/deleteRoom", {
                    id: id,
                }, function (data) {
                    data = JSON.parse(data);
                    if (data.status == "success") {
                        swal("Thông báo!", data.message, "success");
                        $('#row_'+id).remove();
                    } else {
                        swal("Cảnh báo!", data.message, "error");
                    }
                });
            } else {
              return;
            }
          });
    });

    $(document).on('click', '.btn-edit-room',function (e) { 
        e.preventDefault();
        let id = $(this).attr('data-id');
        let name = $(this).attr('data-name');
        let size = $(this).attr('data-size');
        let rentCost = $(this).attr('data-rentCost');

        $('#editRoomName').val(name);
        $('#editRoomSize').val(size);
        $('#editRoomPrice').val(rentCost);
        $('#editRoomId').val(id);
    });

    $(document).on('click', '#editRoomSubmit', function (e) { 
        e.preventDefault();
        // Get values
        let name = $('#editRoomName').val();
        let size = $('#editRoomSize').val();
        let rentCost = $('#editRoomPrice').val();
        let id = $('#editRoomId').val();

        // Post to API
        $.post("./admin/api/updateRoom", {
            id: id,
            name: name,
            size: size,
            rentCost: rentCost,
        }, function (data) {
            data = JSON.parse(data);
            if (data.status == "success") {
                swal("Thông báo!", data.message, "success");
                $("#row_"+id+">td").eq(1).html(name);
                $("#row_"+id+">td").eq(2).html(size);
                $("#row_"+id+">td").eq(3).html(commaSeparateNumber(rentCost) + " VNĐ");
                $("#row_"+id+">td>.btn-group>button").eq(0).attr('data-name', name);
                $("#row_"+id+">td>.btn-group>button").eq(0).attr('data-size', size);
                $("#row_"+id+">td>.btn-group>button").eq(0).attr('data-rentCost', rentCost);
                $('#editRoomModal').modal('hide');
            } else {
                swal("Cảnh báo!", data.message, "error");
            }
        });
    });

    $(document).on('click', '#createRoomSubmit', function (e) { 
        e.preventDefault();
        // Get values
        let name = $('#createRoomName').val();
        let size = $('#createRoomSize').val();
        let rentCost = $('#createRoomPrice').val();

        // Post to API
        $.post("./admin/api/addRoom", {
            name: name,
            size: size,
            rentCost: rentCost,
        }, function (data) {
            data = JSON.parse(data);
            if (data.status == "success") {
                swal("Thông báo!", data.message, "success");
                $('#createRoomModal').modal('hide');

                $('#createRoomName').val('');
                $('#createRoomSize').val('');
                $('#createRoomPrice').val('');

                let num = $('#roomTable>tr').length + 1;

                $('#roomTable').append(`
                    <tr id="row_${data.id}">
                        <td>${num}</td>
                        <td>${name}</td>
                        <td>${size}</td>
                        <td>${commaSeparateNumber(rentCost)} VNĐ</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-primary btn-edit-room" data-toggle="modal" data-target="#editRoomModal" data-id="${data.id}" data-name="${name}" data-size="${size}" data-rentCost="${rentCost}">Sửa</button>
                                <button type="button" class="btn btn-danger btn-delete-room" data-id="${data.id}">Xóa</button>
                            </div>
                        </td>
                    </tr>
                `);
            } else {
                swal("Cảnh báo!", data.message, "error");
            }
        });
    });

    function commaSeparateNumber(val){
        while (/(\d+)(\d{3})/.test(val.toString())){
          val = val.toString().replace(/(\d+)(\d{3})/, '$1'+','+'$2');
        }
        return val;
      }
});