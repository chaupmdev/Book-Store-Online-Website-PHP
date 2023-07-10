var BASE_URL = 'http://localhost:3000/Api/'
var API_AUTHEN = 'authen.php';
var AUTHEN_DHS = 'DanhSachDonHang';
var AUTHEN_CTDHS = 'ChiTietDonHang';
var AUTHEN_VALUES_PHANTRANG = 'GetValuesPhanTrang';
var AUTHEN_CAPNHATTRANGTHAI = 'CapNhatTrangThai';
var AUTHEN_TIMKIEMDONHANG = 'TimKiemDonHang';
var AUTHEN_LAYSOLUONGTRANG ='LaySoLuongTrang';
var AUTHEN_VALUES = 'GetValues';
var AUTHEN_TRANGTHAITAIKHOAN = 'CapNhatTrangThaiTaiKhoan';
var AUTHEN_XOATAIKHOAN = 'XoaTaiKhoan';
var AUTHEN_TUCHOIDONHANG = "TuChoiDonHang";
var AUTHEN_VALUES_PHANTRANG_LOC_SACH = "LoadPhanTrangLocSach";

//function CallApi(input){
//	return $.post(BASE_URL+API_AUTHEN,input,function(data){			
//		return data;
//	},"json");
//}

//var CallApi = (input) => {
//	return (axios.post(BASE_URL+API_AUTHEN,input)
//        .then((response) =>{
//		console.log(response.data) }));
//}