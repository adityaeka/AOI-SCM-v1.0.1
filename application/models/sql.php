<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sql extends CI_Model {
    
    public function __construct(){
        parent::__construct();
    }
    function f_web_po_header(){
    	$query = "
    		 SELECT DISTINCT 
				po.c_order_id,
				po.c_bpartner_id,
				bp.name AS supplier,
				po.documentno,
				CASE
				WHEN (po.m_warehouse_id = ANY (ARRAY[1000001::numeric, 1000011::numeric])) THEN '1'::text
				ELSE '2'::text
				END AS type_po,
				po.m_warehouse_id,
				po.created AS create_po,
				po.updated AS update_po
				FROM ((c_order po
				LEFT JOIN c_bpartner bp ON ((bp.c_bpartner_id = po.c_bpartner_id)))
				LEFT JOIN c_orderline pol ON ((po.c_order_id = pol.c_order_id)))
				WHERE (((((po.docstatus = ANY (ARRAY['CO'::bpchar, 'DR'::bpchar])) AND (po.issotrx = 'N'::bpchar)) AND ((pol.qtyordered - pol.qtydelivered) > (0)::numeric)) AND (po.c_doctype_id <> (1000016)::numeric)) AND (po.c_doctypetarget_id <> (1000127)::numeric)) AND po.c_bpartner_id = ".$c_bpartner_id;
    		$data = $this->db2->query($query);
    		return $data;
    }
    function f_web_po_detail($c_bpartner_id){
    	$query = "
    	 SELECT po.c_order_id,
    pol.c_orderline_id,
    po.c_bpartner_id,
    bp.name AS supplier,
    po.documentno,
    pol.m_product_id,
    pro.value AS item,
    pol.qtyordered,
    pol.qtydelivered,
    pol.qtyentered,
    pol.c_uom_id,
    uo.uomsymbol,
        CASE
            WHEN (pol.qtydelivered = (0)::numeric) THEN 'open'::text
            WHEN (((pol.qtyordered - pol.qtydelivered) > (0)::numeric) AND (pol.qtydelivered <> (0)::numeric)) THEN 'partial'::text
            WHEN ((pol.qtyordered - pol.qtydelivered) <= (0)::numeric) THEN 'close'::text
            ELSE NULL::text
        END AS status,
    pro.name AS desc_product,
    mpc.value AS category,
        CASE
            WHEN (pro.m_product_category_id = (1000003)::numeric) THEN '1'::text
            WHEN (pro.m_product_id IS NULL) THEN '-'::text
            ELSE '2'::text
        END AS type_po,
    pol.datepromised,
    string_agg(DISTINCT (rl.poreference)::text, ', '::text) AS pobuyer,
    pol.kst_deliverydate,
    po.m_warehouse_id
   FROM (((((((c_order po
     LEFT JOIN c_orderline pol ON ((po.c_order_id = pol.c_order_id)))
     LEFT JOIN c_uom uo ON ((uo.c_uom_id = pol.c_uom_id)))
     LEFT JOIN m_product pro ON ((pol.m_product_id = pro.m_product_id)))
     LEFT JOIN c_bpartner bp ON ((bp.c_bpartner_id = po.c_bpartner_id)))
     LEFT JOIN m_product_category mpc ON ((mpc.m_product_category_id = pro.m_product_category_id)))
     LEFT JOIN kst_orderdetail odt ON ((pol.c_orderline_id = odt.c_orderline_id)))
     LEFT JOIN m_requisitionline rl ON ((odt.m_requisitionline_id = rl.m_requisitionline_id)))
  WHERE ((((((po.docstatus = ANY (ARRAY['CO'::bpchar, 'DR'::bpchar])) AND (po.issotrx = 'N'::bpchar)) AND (po.c_doctype_id <> (1000016)::numeric)) AND ((pol.qtyordered - pol.qtydelivered) > (0)::numeric)) AND (po.c_doctypetarget_id <> (1000127)::numeric)) AND (pol.isclosed = 'N'::bpchar)) AND po.c_bpartner_id = 1001126
  GROUP BY po.c_order_id, pol.c_orderline_id, po.c_bpartner_id, bp.name, po.documentno, pol.m_product_id, pro.value, pol.qtyordered, pol.qtydelivered, pol.qtyentered, pol.c_uom_id, uo.uomsymbol, pro.name, mpc.value, pol.datepromised,
        CASE
            WHEN (pro.m_product_category_id = (1000003)::numeric) THEN '1'::text
            WHEN (pro.m_product_id IS NULL) THEN '-'::text
            ELSE '2'::text
        END, pol.kst_deliverydate, po.m_warehouse_id, pro.kst_name;
    	";
    }
}	