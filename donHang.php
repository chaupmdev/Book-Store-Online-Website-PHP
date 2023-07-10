<?php
include 'config.php';
	class DonHang
	{
		var $MaDonHang;	
		var $MaTTLH;	
		var $NgayMua;	
		var $MaVoucher;	
		var $MaLoaiGH;	
		var $PhuongThucThanhToan;	
		var $TrangThai;	
		var $ThanhTien;	
		var $GhiChu;
		
		function __construct($MaDonHang,$MaTTLH,$NgayMua,$MaVoucher,$MaLoaiGH,$PhuongThucThanhToan,$TrangThai,$ThanhTien,$GhiChu)
		{
			$this->MaDonHang= $MaDonHang;	
			$this->MaTTLH = $MaTTLH;	
			$this->NgayMua = $NgayMua;	
			$this->MaVoucher = $MaVoucher;	
			$this->MaLoaiGH = $MaLoaiGH;					
			$this->TrangThai = $TrangThai;	
			$this->ThanhTien = $ThanhTien;	
			$this->GhiChu = $GhiChu;
			$this->PhuongThucThanhToan = $PhuongThucThanhToan;
		}
	}
class DonHangs
{				
	private $donHangs = array();
	var $conn;
	function __construct()
	{
		$conn = mysqli_connect('localhost','root','','phphorizon',3301) or die('connection failed');
		$dhs_query = mysqli_query($conn, "SELECT * FROM `donhang`") or die('query failed');
         if(mysqli_num_rows($dhs_query) > 0)
            while($dh = mysqli_fetch_assoc($dhs_query))
				$this->add(new DonHang($dh['MaDonHang'],$dh['MaTTLH'],$dh['NgayMua'],$dh['MaVoucher'],$dh['MaLoaiGH'],$dh['PhuongThucThanhToan'],$dh['TrangThai'],$dh['ThanhTien'],$dh['GhiChu']));			
	}
	function add($donHang)
	{
		 array_push($this->donHangs,$donHang);
	}
	function get($maDonHang)
	{
		foreach($this->donHangs as $item)		
			if(strcasecmp($item->MaDonHang,$maDonHang))
				return $item;
		return null;
	}
	function geti($index)
	{
		return $this->donHangs[$index];
	}
	function getALL()
	{
		return $this->donHangs;
	}
	function update($donHang)
	{
		mysqli_query($conn, "UPDATE `products` SET name = '$update_name', price = '$update_price' WHERE id = '$update_p_id'") or die('query failed');
	}
}
?>