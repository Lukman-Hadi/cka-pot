<?php

function tgl_indo($tgl){
    $bln = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
    $tanggal = substr($tgl,8,2);
    $bulan = substr($tgl,5,2);
    $tahun = substr($tgl,0,4);
    return $tanggal.' '.$bln[(int)$bulan-1].' '.$tahun;       
}

function bln_indo($tgl){
    $bln = array("Jan", "Feb", "Maret", "April", "Mei", "Juni", "Juli", "Agust", "Sep", "Okt", "Nov", "Des");
    $tanggal = substr($tgl,8,2);
    $bulan = substr($tgl,5,2);
    $tahun = substr($tgl,0,4);
    return $tanggal.' '.$bln[(int)$bulan-1].' '.$tahun;       
}
function bulan($bln){
    switch ($bln){
        case 1: 
            return "Januari";
            break;
        case 2:
            return "Februari";
            break;
        case 3:
            return "Maret";
            break;
        case 4:
            return "April";
            break;
        case 5:
            return "Mei";
            break;
        case 6:
            return "Juni";
            break;
        case 7:
            return "Juli";
            break;
        case 8:
            return "Agustus";
            break;
        case 9:
            return "September";
            break;
        case 10:
            return "Oktober";
            break;
        case 11:
            return "November";
            break;
        case 12:
            return "Desember";
            break;
    }
}
function jam($tgl){
    $jam = substr($tgl,11,2);
    $menit = substr($tgl,14,2);
    $detik = substr($tgl,17,2);
    return $jam.':'.$menit.':'.$detik;       
}
function is_login()
{
    $ci = get_instance();
    if (!$ci->session->userdata('_id')) {
        return false;
    } else {
        return true;
    }
}
function checked_akses($id_user_level,$id_menu){
    $ci = get_instance();
    $ci->db->where('id_posisi',$id_user_level);
    $ci->db->where('id_menu',$id_menu);
    $data = $ci->db->get('tbl_levels');
    if($data->num_rows()>0){
        return "checked='checked'";
    }
}