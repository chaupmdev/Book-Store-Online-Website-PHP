let loidls = document.querySelectorAll('.loidl');
let HoVaTen = document.getElementById('HoVaTen');
let SoDienThoai = document.getElementById('SoDienThoai');
let KT = document.getElementById('KT');
let HuyLuuDiaChi = document.getElementById('HuyLuuDiaChi');
let ThemDiaChiMoi = document.getElementById('ThemDiaChiMoi');
HuyLuuDiaChi.addEventListener("click", function(){
    loidls.forEach(item => item.innerHTML = "");
})
KT.addEventListener("click", function () {
    KiemTraTT();
})
function KiemTraTT() {
    let check = true;
    if (HoVaTen.value == null || HoVaTen.value.trim().length == 0) {
        check = false;
        loidls[0].innerHTML = "Họ và tên không được để trống!";
    }
    else {
        loidls[0].innerHTML = "";
    }
    if (SoDienThoai.value == null || SoDienThoai.value.trim().length == 0) {
        check = false;
        loidls[1].innerHTML = "Số điện thoại không được để trống!";
    }
    else {
        if (SoDienThoai.value.trim().length < 10) {
            loidls[1].innerHTML = "Số điện thoại sai định dạng!";
            check = false;
        }

        else {
            loidls[1].innerHTML = "";
        }
    }
    if (ChonXa.disabled == true || ChonXa.selectedIndex == 0) {
        loidls[2].innerHTML = "Vui lòng chọn đầy đủ địa chỉ!!!"
        check = false;
    }
    else {
        loidls[2].innerHTML = "";
    }
    if (diachicuthe.value == null || diachicuthe.value.trim().length == 0) {
        loidls[3].innerHTML = "Vui lòng nhập địa chỉ cụ thể!!!"
        check = false;
    }
    else {
        loidls[3].innerHTML = "";
    }
    if (check) {
        ThemDiaChiMoi.click();
    }
}




var tinh = document.getElementById("tinh");
var vtinh = vquan = vxa = null;
if (tinh != null) {
    var quan = document.getElementById("quan");
    var xa = document.getElementById("xa");
    vtinh = tinh.value;
    vquan = quan.value;
    vxa = xa.value;
}
const host = "https://provinces.open-api.vn/api/";
var callAPI = (api) => {
    return axios.get(api)
        .then((response) => {
            renderDataShow(response.data, "province", vtinh);
            callApiDistrict(host + "p/" + $("#province").val() + "?depth=2");
        });
}
var callApiDistrict = (api) => {
    return axios.get(api)
        .then((response) => {
            renderDataShow(response.data.districts, "district", vquan);
            callApiWard(host + "d/" + $("#district").val() + "?depth=2");
        });
}
var callApiWard = (api) => {
    return axios.get(api)
        .then((response) => {
            renderDataShow(response.data.wards, "ward", vxa);
            vtinh = vquan = vxa = null;
        });
}

var renderDataShow = (array, select, value = undefined) => {
    let row = '<option value=""> Chọn </option>';
    if (array != null)
        array.forEach(element => {
            if (element.name == value)
                row += `<option selected value="${element.code}">${element.name}</option>`
            else
                row += `<option value="${element.code}">${element.name}</option>`
        });
    document.querySelector("#" + select).innerHTML = row
}
callAPI('https://provinces.open-api.vn/api/?depth=1');
$("#province").change(() => {
    callApiDistrict(host + "p/" + $("#province").val() + "?depth=2");
    result.value = "";
});
$("#district").change(() => {
    callApiWard(host + "d/" + $("#district").val() + "?depth=2");
    result.value = "";
});
$("#ward").change(() => {
    printResult();
})
var printResult = () => {
    if ($("#ward").val() != "") {
        let s = $("#ward option:selected").text() + ", "
            + $("#district option:selected").text() + ", "
            + $("#province option:selected").text();
        result.value = s;
    }
}
