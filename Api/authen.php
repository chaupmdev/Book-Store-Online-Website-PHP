<?php
	const PAGE_NUMBER_MAX = 5;
	include 'connection.php';
	include 'SendMail.php';
	include 'SendSMS.php';
 	$action = getPOST('action');
	if(empty($action))
		$action = getGET('action');
	switch($action)
	{
		case 'ChiTietDonHang':
			getTTDonHang(getPOST("maDonHang"));
			break;
		case 'CapNhatTrangThai':								 
			capNhatTrangThai(getPOST("maDonHang"),getPOST("trangthai"));
			break;
		case 'GetValuesPhanTrang':
			getValuesPhanTrang();
			break;
		case 'TimKiemDonHang':
			timKiemDonHang(getPOST("txtsearch"));
			break;
		case 'LaySoLuongTrang':
			getSoLuongTrang();
			break;
		case 'GetValues':
			getValues();
			break;
		case 'CapNhatTrangThaiTaiKhoan':
			capNhatTrangThaiTaiKhoan();
			break;
		case 'XoaTaiKhoan':
			xoaTaiKhoan();
			break;
		case 'TuChoiDonHang':
			tuChoiDonHang();
			break;
		case 'LoadPhanTrangLocSach':
			loadPhanTrangLocSach();
			break;
		case 'TheLoaiSach':
			getTheLoaiSach();
			break;
		case 'XoaTheLoai':
			xoaTheLoai();
			break;
		case 'ThemTheLoai':
			themTheLoai();
			break;
		case 'CapNhatTheLoai':
			capNhatTheLoai();
			break;
		
	}
	function capNhatTheLoai()
	{
		$maTheLoai = getPOST("maTheLoai");;
		$tenTheLoai = getPOST("tenTheLoai");		
		if(executeResult("SELECT * FROM `theloaisach` WHERE TenTheLoai = '$tenTheLoai' and MaTheLoai <> '$maTheLoai'",true)!=null)
			return echoJson([
				"status" =>-1,
				"msg"=>"Tên thể loại bị trùng với 1 mã loại khác!!!",
				"type"=>"info",
			]);
		
			execute("UPDATE theloaisach set TenTheLoai = '$tenTheLoai' WHERE MaTheLoai = '$maTheLoai'");
				return echoJson([
					"status" =>1,
					"msg"=>"Cập nhật thông tin thể loại thành công",
					"type"=>"success",
				]);
	}
	function themTheLoai()
	{
		$tenTheLoai = getPOST("tenTheLoai");
		if(executeResult("SELECT * FROM `theloaisach` WHERE TenTheLoai = '$tenTheLoai'",true)!=null)
			return echoJson([
				"status" =>-1,
				"msg"=>"Tên thể loại đã tồn tại!!!",
				"type"=>"info",
			]);
		$sl = ((int)executeResult("SELECT count(*) as soluong from theloaisach",true)['soluong']) + 1;
		do
		{
			$maTheLoaiMoi = "TL00".strval($sl=$sl+1);			
			if(executeResult("SELECT * from theloaisach where MaTheLoai ='$maTheLoaiMoi'",true)==null)
			{
				execute("INSERT INTO `theloaisach`(`MaTheLoai`, `TenTheLoai`) VALUES ('$maTheLoaiMoi','$tenTheLoai')");
				return echoJson([
					"status" =>1,
					"msg"=>"Thêm thể loại thành công\nChi tiết: mã: $maTheLoaiMoi, thể loại: $tenTheLoai",
					"type"=>"success",
				]);
			}	
		}while(true	);
		
	}
	function xoaTheLoai()
	{
		try {
			$maTheLoai = getPOST("maTheLoai");
			$data = executeResult("select * from theloaisach where MaTheLoai = '$maTheLoai'");
			if($data!=null)
				return echoJson([
					"status" =>-1,
					"msg"=>"Tồn tại ".count($data)." sách thuộc thể loại này, không thể xóa",
				]);
			execute("DELETE FROM `theloaisach` WHERE MaTheLoai = '$maTheLoai'");
			return echoJson([
				"status" =>1,
				"msg"=>"Xóa thành công",
			]);
		} catch (\Throwable $th) {
			return echoJson([
				"status" =>-1,
				"msg"=>"Đã xảy ra lỗi, vui lòng thử lại",
			]);
		}
		
	}
	function getTheLoaiSach()
	{
		$sql = "SELECT MaTheLoai, TenTheLoai FROM `theloaisach` ";
		return echoJson($res = [
			"status"=>1,
			"data"=>executeResult($sql),		
		]);
	}
	function loadPhanTrangLocSach()
	{		
		$page = getPOST("page");
		$conHang = getPOST("conHang");
		$sapHetHang = getPOST("sapHetHang");
		$hetHang = getPOST("hetHang");
		$txttimkiem = getPOST("txttimkiem");

		if($page<=0)
			$page = 1;
		$curentIndex = ($page - 1)*PAGE_NUMBER_MAX;
		$sql ="SELECT * FROM `sach` 
				WHERE (MaSach like '%$txttimkiem%' or TenSach like '%$txttimkiem%'
				or `TacGia` like '%$txttimkiem%' or `SoTrang`  like '%$txttimkiem%'
				or `GiaBan` like '%$txttimkiem%' or`SoLuongTon` like '%$txttimkiem%' 
				or`MaNXB` like '%$txttimkiem%' or`MaTheLoai` like '%$txttimkiem%' 
				or`HinhAnh` like '%$txttimkiem%' or`NoiDungTomTat` like '%$txttimkiem%') ";
		$dk=[];
		if($conHang == "true")
			$dk[] = " SoLuongTon > 10";
		if($sapHetHang == "true")
			$dk[] = " SoLuongTon < 10";	
		if($hetHang == "true")
			$dk[] = " SoLuongTon = 0";	
		$sql2="";
		foreach($dk as $i)
			$sql2 .=$i." or ";
		if(!empty($sql2))
			$sql = $sql." and ( ".$sql2." 1>2 )";
		$sql3 =  $sql." LIMIT $curentIndex ,".PAGE_NUMBER_MAX;
		$data = executeResult($sql3);	
		if(count($data)==0)
			$res = [
				"status" => -1,
				"msg" =>"Không tìm thấy dữ liệu",
				];
		else
		{			
			$dt = executeResult($sql);
			$total = count($dt);
			$numpages = ceil($total/PAGE_NUMBER_MAX);
			$res = [
				"status"=> 1,
				"msg" =>"Thành công",
				"numpages" => $numpages,
				"sach" => $data,					
			];
		}
		return echoJson($res);
	}
	function tuChoiDonHang()
	{
		$maDonHang = getPOST("maDonHang");
		$trangThai = getPOST("trangThai");

		$sql = "SELECT tk.Email, tt.SDT FROM donhang dh JOIN thongtinlienhe tt
		on dh.MaTTLH = tt.MaTTLH JOIN taikhoan tk
		on tt.MaTaiKhoan = tk.MaTaiKhoan WHERE MaDonHang = '$maDonHang'";
		$tt = executeResult($sql,true);
		$email = $tt["Email"];
		$sdt = $tt["SDT"];
		$noiDung = "Đơn hàng $maDonHang của bạn đã bị từ chối!!!";
		GuiMailThongBaoTinhTrang($email,$noiDung);
		GuiTinNhanSMS($sdt,$noiDung);
		$sql ="update donhang set TrangThai = 'Bị từ chối' where MaDonHang ='$maDonHang'";
		if(strcasecmp($trangThai,"Đang xử lý")==0)
			{
				$ctdh = executeResult("SELECT * from ChiTietDonHang where MaDonHang ='$maDonHang'");
				foreach($ctdh as $ct)				
					execute("UPDATE sach set SoLuongTon = SoLuongTon + ".$ct['SoLuong']." WHERE MaSach = '".$ct['MaSach']."'");				
			}
		execute($sql);
		$res =[
			"status" => 1,
			"msg" =>"Từ chối đơn hàng thành công!",
			"trangthai" => "Bị từ chối"
			];

		return echoJson($res);	

	}
	function getSoLuongTrang()
	{
		$tblName = getPOST("tblname");
		$sql ="SELECT COUNT(*) as SL FROM $tblName";
		$data = executeResult($sql,true);
		$total = $data['SL'];
		$numpages = ceil($total/PAGE_NUMBER_MAX);
		$res = [
				"status"=>1,
				"numpages"=>$numpages,		
			];
		return echoJson($res);
	}
	function getValuesPhanTrang()
	{
		$tblName = getPOST("tblname");
		$page = getPOST("page");
		if($page<=0)
			$page = 1;
		$curentIndex = ($page - 1)*PAGE_NUMBER_MAX;
		$sql ="SELECT * FROM $tblName LIMIT $curentIndex ,".PAGE_NUMBER_MAX;
		$data = executeResult($sql);	
		if(count($data)==0)
			$res = [
				"status" => -1,
				"msg" =>"Không tìm thấy dữ liệu",
				];
		else
		{
			$sql ="SELECT COUNT(*) as SL FROM $tblName";
			$dt = executeResult($sql,true);
			$total = $dt['SL'];
			$numpages = ceil($total/PAGE_NUMBER_MAX);
			$res = [
				"status"=> 1,
				"msg" =>"Thành công",
				"numpages" => $numpages,
				"$tblName" => $data,		
			];
		}
		return echoJson($res);
	}

	function timKiemDonHang($txtsearch)
	{
		$sql = "SELECT * FROM donhang where MaDonHang like '%".$txtsearch."%'";
		$data = executeResult($sql);	
		$res = "";
		if(count($data)==0)
			$res = [
				"status" => -1,
				"msg" =>"Không tìm thấy đơn hàng nào có mã ".$txtsearch."!!!",
				];
		else
			$res = [
				"status"=> 1,
				"msg" =>"Thành công",
				"donhang" => $data,		
			];
		return echoJson($res);
	}
	function getTTDonHang($maDonHang)
	{
		$sql = "SELECT dh.MaDonHang, dh.NgayMua, dh.MaVoucher,lg.TenLoaiGH, dh.PhuongThucThanhToan, dh.TrangThai, dh.ThanhTien, dh.GhiChu, tt.DiaChi, tt.DiaChiCuThe, tt.SDT, tk.HoTen 
				FROM donhang dh join loaigiaohang lg
				on dh.MaLoaiGH = lg.MaLoaiGH join thongtinlienhe tt
				on dh.MaTTLH = tt.MaTTLH join taikhoan tk
				on tt.MaTaiKhoan = tk.MaTaiKhoan 
				WHERE MaDonHang = '$maDonHang'";
		$dh = executeResult($sql,true);
		if(count($dh)==0)
		{
			$res =[
			"status" => -1,
			"msg" =>"không tồn tại đơn hàng có mã ".$maDonHang,
			];
		}
		else
		{
			$ctdhs = executeResult("SELECT s.MaSach, s.HinhAnh, s.TenSach, s.GiaBan, ct.SoLuong, ct.TongTien 
				FROM chitietdonhang ct JOIN sach s
				on ct.MaSach = s.MaSach
				WHERE MaDonHang = '$maDonHang'");
			$res =[
				"status" =>1,
				"msg" =>"",
				"donhang" => $dh,
				"chitietdonhang" => $ctdhs 
			];
		}
		echoJson($res);
	}
	function capNhatTrangThai($maDonHang,$trangthai)
	{
		if(strcasecmp($trangthai,"Đã hủy")==0 || strcasecmp($trangthai,"Đã giao")==0 || strcasecmp($trangthai,"Bị từ chối")==0)		
		{
			$res =[
			"status" => -1,
			"msg" =>"Trạng thái này không thể được cập nhật!",
			];
		}
		else
		{
			$sql = "SELECT tk.Email, tt.SDT FROM donhang dh JOIN thongtinlienhe tt
			on dh.MaTTLH = tt.MaTTLH JOIN taikhoan tk
			on tt.MaTaiKhoan = tk.MaTaiKhoan WHERE MaDonHang = '$maDonHang'";
			$tt = executeResult($sql,true);
			$email = $tt["Email"];
			$sdt = $tt["SDT"];
			if(strcasecmp($trangthai,"Chờ xác nhận")==0)
			$ttmoi = "Đang xử lý";
			else if(strcasecmp($trangthai,"Đang xử lý")==0)
			$ttmoi = "Đang giao";
			else
			$ttmoi = "Đã giao";
			$noiDung = "Đơn hàng $maDonHang của bạn đang được xử lý! Vui lòng chờ những thông báo tiếp theo";
			switch($ttmoi)
			{
				case 'Đang giao':
					$noiDung = "Đơn hàng $maDonHang của bạn đã giao cho đơn vị vận chuyển và đang trên đường đến tay của bạn! Vui lòng chờ những thông báo tiếp theo";
					break;
				case 'Đã giao':
					$noiDung = "Bạn đã nhận được đơn hàng $maDonHang, bạn cảm thấy sao về đơn hàng này, có thế cho chúng tôi xin đánh giá về chất lượng của đươn hàng trên trang web của chúng tôi!";
					break;
			}
			GuiMailThongBaoTinhTrang($email,$noiDung);
			GuiTinNhanSMS($sdt,$noiDung);
			$sql ="update donhang set TrangThai = '$ttmoi' where MaDonHang ='$maDonHang'";
			execute($sql);
			if(strcasecmp($ttmoi,"Đang xử lý")==0)
			{
				$ctdh = executeResult("SELECT * from ChiTietDonHang where MaDonHang ='$maDonHang'");
				foreach($ctdh as $ct)				
					execute("UPDATE sach set SoLuongTon = SoLuongTon - ".$ct['SoLuong']." WHERE MaSach = '".$ct['MaSach']."'");				
			}
			$res =[
				"status" => 1,
				"msg" =>"Cập nhật trạng thái thành công!",
				"trangthai" => $ttmoi
				];
		}
		return echoJson($res);	
	}
	function getValues()
	{
		$tblName = $_POST["tblName"];
		$sql = "SELECT * FROM $tblName";
		$data = executeResult($sql);	
		$res = "";
		if(count($data)==0)
			$res = [
				"status" => -1,
				"msg" =>"Load dữ liệu thất bại",
				];
		else
			$res = [
				"status"=> 1,
				"msg" =>"Thành công",
				"$tblName" => $data
			];
		return echoJson($res);
	}
	function capNhatTrangThaiTaiKhoan()
	{
		try
		{
		$maTaiKhoan = getPOST("mataikhoan");
		$khoa = getPOST("trangthai");
		$sql = "UPDATE `taikhoan` SET BiKhoa = $khoa WHERE MaTaiKhoan ='$maTaiKhoan'";
		execute($sql);		
		$res = [
				"status"=> 1,
				"msg" =>"Cập nhật trạng thái thành công!",
				"type"=>"success"
			];
		}
		catch (Exception $e)
		{
			$res = [
				"status"=> -1,
				"msg" =>"Đã xảy ra lỗi!",
				"type"=>"error"
			];
		}
		return echoJson($res);
	}
	function xoaTaiKhoan()
	{
		try
		{
		$maTaiKhoan = getPOST("mataikhoan");
		$khoa = getPOST("trangthai");
		$sql = "DELETE FROM `taikhoan` WHERE MaTaiKhoan ='$maTaiKhoan'";
		execute($sql);		
		$res = [
				"status"=> 1,
				"msg" =>"Xóa tài khoản thành công!",
				"type"=>"success",
			];
		}
		catch (Exception $e)
		{
			$res = [
				"status"=> -1,
				"msg" =>"Đã xảy ra lỗi!",
				"type"=>"error"
			];
		}
		return echoJson($res);
	}
	//function getSach($maSach)
	//{
	//	$sql = "SELECT s.MaSach, s.HinhAnh, s.TenSach, s.GiaBan, ct.SoLuong, ct.TongTien 
	//			FROM chitietdonhang ct JOIN sach s
	//			on ct.MaSach = s.MaSach
	//			WHERE MaDonHang = '$maSach'";
	//	$sach = executeResult($sql);
	//	if(count($sach)==0)
	//	{
	//		$res =[
	//		"status" => -1,
	//		"msg" =>"không tồn tại sách có mã "+$maSach,
	//		];
	//	}
	//	else
	//	{
	//		$res =[
	//		"status" => 1,
	//		"msg" =>"",
	//		"sach"=>$sach
	//		];
	//	}
	//	echoJson($res);
	//}
	function echoJson($res)
	{
		echo json_encode($res,JSON_UNESCAPED_UNICODE);
	}
	?>