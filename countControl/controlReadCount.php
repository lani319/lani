<?
//�۾� ����		���� 4�� / ��ħ 11�� / ���� 7��

include_once "../../_config/db.connect.php";
include_once "../../_config/sys.config.php";
include_once "../../_libs/base_lib.php";
include_once "../../_libs/common_lib.php";
include_once "../../_libs/coin_lib.php";

/* DB Connection */
$DB = DBConn($_HOST_NAME, $_USER_NAME, $_PASSWORD, $_DB);
/*
SELECT idx,hit,regDate FROM NaraBoard_502news WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC; //502����
SELECT idx,hit,recommend,signdate FROM stBoard WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(signdate,10)) <=2 AND uidx IN (12,34904) AND bn='st' ORDER BY idx DESC;//������ ��������
SELECT idx,hit,regDate FROM NaraBoard_analysis WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC; //������õ
SELECT idx,hit,regDate FROM NaraBoard_firstclass WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC; //1��޺м���
SELECT idx,hit,regDate FROM NaraBoard_pcolumn WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC; //�����̳�Į��
SELECT idx,hit,regDate FROM NaraBoard_knowhow WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC; //�Ÿų��Ͽ�

SELECT idx,hit,regDate FROM NaraBoard_jqna WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC; //���� ���� ����
SELECT idx,hit,regDate FROM NaraBoard_cosdaq_qna WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC; //�ڽ��� ���� ����
SELECT idx,hit,regDate FROM NaraBoard_study WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC; //���ι�
SELECT idx,hit,regDate FROM NaraBoard_photo WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC; //502������
SELECT idx,hit,regDate FROM NaraBoard_talkoflife WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC; //������ �̾߱�

SELECT idx,hit,regDate FROM NaraBoard_jtalk WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC //�ֽ��̾߱�
SELECT idx,hit,regDate FROM NaraBoard_religion WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC //������
SELECT idx,hit,regDate FROM NaraBoard_broadafter WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC //��û�ı�
SELECT idx,hit,regDate FROM NaraBoard_notice WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC //��������
SELECT idx,hit,regDate FROM NaraBoard_qna WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC //�����亯

SELECT idx,hit,regDate FROM NaraBoard_faq WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC //�����ϴ� ����
SELECT idx,hit,regDate FROM NaraBoard_first_2 WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC //FIRST ���ͷ�
SELECT idx,hit,regDate FROM NaraBoard_first_member WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC //FIRST ȸ�� �Ÿ�����
SELECT idx,hit,regDate FROM NaraBoard_sky_earning WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC //VIP �Ÿ�����
SELECT idx,hit,regDate FROM NaraBoard_earningRate WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) <=2 ORDER BY idx DESC //PC ��� FIRST �Ÿ�����


SELECT idx,hit,signdate FROM csBoard WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(signdate,10)) <=2 ORDER BY idx DESC //�Ϲ� ȸ�� �Ÿ��򰡽�
SELECT idx,hit,regdate FROM csBoard_futures WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regdate,10)) <=2 ORDER BY idx DESC //�����̾� �Ÿ��򰡽�
*/
//�۾� ���� 3�� ����
$sql = "update NaraBoard_502news set hit = hit+23 WHERE TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0"; mysql_query($sql);
//$sql = " update stBoard set hit = hit+23 where TO_DAYS(NOW())-TO_DAYS(LEFT(signdate,10)) =0 AND uidx IN (34904) AND bn='st'";mysql_query($sql);
//$sql = " update NaraBoard_analysis set hit = hit+23,recommend = recommend+3 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_firstclass set hit = hit+23 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_pcolumn set hit = hit+23 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_knowhow set hit = hit+23 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_jqna set hit = hit+17,recommend = recommend+3 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_cosdaq_qna set hit = hit+23,recommend = recommend+3 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_study set hit = hit+17 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_photo set hit = hit+23 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_talkoflife set hit = hit+23 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_jtalk set hit = hit+17 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_religion set hit = hit+23 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
$sql = " update NaraBoard_broadafter set hit = hit+1 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_notice set hit = hit+27 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_qna set hit = hit+23 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update NaraBoard_faq set hit = hit+23 where TO_DAYS(NOW())-TO_DAYS(LEFT(regDate,10)) =0";mysql_query($sql);
//$sql = " update csBoard set hit = hit+17 where TO_DAYS(NOW())-TO_DAYS(LEFT(signdate,10)) =0";mysql_query($sql);
//$sql = " update csBoard_futures set hit = hit+17 where TO_DAYS(NOW())-TO_DAYS(LEFT(regdate,10)) =0";mysql_query($sql);

?>