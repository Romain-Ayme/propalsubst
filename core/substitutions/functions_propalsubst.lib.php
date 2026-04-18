<?php
/**
 * Substitution functions for commercial proposals (PropalSubst)
 *
 * Added variables:
 *   __PROPAL_DATE_END__          → Validity end date (e.g. 31/12/2025)
 *   __PROPAL_DATE_END_LONG__     → Validity end date in full text (e.g. 31 December 2025)
 *   __PROPAL_DAYS_REMAINING__    → Number of days remaining before expiry
 *   __PROPAL_DATE_START__        → Proposal creation date
 *   __PROPAL_PAYMENT_TERMS__     → Payment conditions
 *   __PROPAL_PAYMENT_MODE__      → Payment method
 */

/**
 * Function automatically called by Dolibarr to complete the substitution array
 *
 * @param array     $substitutionarray  Substitution array to complete (passed by reference)
 * @param Translate $outputlangs        Language object
 * @param object    $object             Current object (propal, invoice, etc.)
 * @param array     $parameters         Additional parameters
 * @return int                          1 if OK, 0 if error
 */
function propalsubst_completesubstitutionarray(&$substitutionarray, $outputlangs, $object, $parameters)
{
    global $db;

    // Only process commercial proposals
    if (!is_object($object) || $object->element !== 'propal') {
        return 1;
    }

    // --- Validity end date (fin_validite = DateEndPropal in Dolibarr source) ---
    if (!empty($object->fin_validite) && $object->fin_validite > 0) {

        // Short format: 31/12/2025
        $substitutionarray['__PROPAL_DATE_END__'] = dol_print_date(
            $object->fin_validite,
            'day',
            false,
            $outputlangs
        );

        // Long format: 31 December 2025
        $substitutionarray['__PROPAL_DATE_END_LONG__'] = dol_print_date(
            $object->fin_validite,
            '%d %B %Y',
            false,
            $outputlangs
        );

        // Days remaining before expiry
        $today         = dol_now();
        $diff          = $object->fin_validite - $today;
        $daysRemaining = (int) round($diff / 86400);

        if ($daysRemaining > 0) {
            $substitutionarray['__PROPAL_DAYS_REMAINING__'] = $daysRemaining.' day'.($daysRemaining > 1 ? 's' : '');
        } elseif ($daysRemaining === 0) {
            $substitutionarray['__PROPAL_DAYS_REMAINING__'] = 'today';
        } else {
            $substitutionarray['__PROPAL_DAYS_REMAINING__'] = 'expired';
        }

    } else {
        $substitutionarray['__PROPAL_DATE_END__']      = '';
        $substitutionarray['__PROPAL_DATE_END_LONG__'] = '';
        $substitutionarray['__PROPAL_DAYS_REMAINING__'] = '';
    }

    // --- Proposal creation date (datep = DatePropal in Dolibarr source) ---
    if (!empty($object->datep) && $object->datep > 0) {
        $substitutionarray['__PROPAL_DATE_START__'] = dol_print_date(
            $object->datep,
            'day',
            false,
            $outputlangs
        );
    } else {
        $substitutionarray['__PROPAL_DATE_START__'] = '';
    }

    // --- Payment conditions ---
    if (!empty($object->cond_reglement_code)) {
        $outputlangs->load('bills');
        $substitutionarray['__PROPAL_PAYMENT_TERMS__'] = $outputlangs->transnoentitiesnoconv(
            'PaymentConditionShort'.$object->cond_reglement_code
        );
        // Fallback to raw label if no translation found
        if ($substitutionarray['__PROPAL_PAYMENT_TERMS__'] === 'PaymentConditionShort'.$object->cond_reglement_code) {
            $substitutionarray['__PROPAL_PAYMENT_TERMS__'] = !empty($object->cond_reglement_doc)
                ? $object->cond_reglement_doc
                : $object->cond_reglement_code;
        }
    } else {
        $substitutionarray['__PROPAL_PAYMENT_TERMS__'] = '';
    }

    // --- Payment method ---
    if (!empty($object->mode_reglement_code)) {
        $outputlangs->load('bills');
        $substitutionarray['__PROPAL_PAYMENT_MODE__'] = $outputlangs->transnoentitiesnoconv(
            'PaymentType'.$object->mode_reglement_code
        );
        if ($substitutionarray['__PROPAL_PAYMENT_MODE__'] === 'PaymentType'.$object->mode_reglement_code) {
            $substitutionarray['__PROPAL_PAYMENT_MODE__'] = $object->mode_reglement_code;
        }
    } else {
        $substitutionarray['__PROPAL_PAYMENT_MODE__'] = '';
    }

    return 1;
}
