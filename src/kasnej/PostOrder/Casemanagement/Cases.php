<?php

namespace kasnej\PostOrder\Casemanagement;


use kasnej\PostOrder\Client;
class Cases extends Client
{

    /**
     * Buyers and sellers can use this call to retrieve detailed information on a case, including case history and (if applicable) refund information, appeal information, and shipment tracking information. <br>
     * The case is identified by the caseId that is passed in as part of the call URI. You must be involved in the case in order to retrieve the case details.
     * @param $caseId
     * @return array
     * @throws ServerException
     */
    public function getCase($caseId)
    {

        return $response = $this->send(HttpClient::GET, sprintf('casemanagement/%s', $caseId)));
    }

    /**
     * Buyers and sellers can use this call to appeal a case decision that was not ruled in their favor by eBay customer support.
     *
     * @param $caseId
     * @return array
     * @throws ServerException
     */
    public function AppealCaseDecision($caseId){
        return $response = $this->send(HttpClient::POST, sprintf('casemanagement/%s/appeal', $caseId)));
    }

    /**
     * This call lets buyers close an open case.<br>
     * Buyers can close an INR case after the item arrives, and they might close a Return case if they decide to keep the item, or have otherwise worked out transaction with the seller.
     *
     * @return array
     * @throws ServerException
     */
    public function closeCase($caseId){
        return $response = $this->send(HttpClient::POST, sprintf('casemanagement/%s/close', $caseId)));
    }

    /**
     * Sellers use this call to issue a full refund to the buyer to resolve an INR or Return case that was filed against the seller.
     *
     * @param $caseId
     * @return array
     * @throws ServerException
     */
    public function issueCaseRefund($caseId){
        return $response = $this->send(HttpClient::POST, sprintf('casemanagement/%s/issue_refund', $caseId)));
    }
}