<?php

class CERL_Validator {

    const TRIPLEDES_CBC = 'http://www.w3.org/2001/04/xmlenc#tripledes-cbc';
    const AES128_CBC = 'http://www.w3.org/2001/04/xmlenc#aes128-cbc';
    const AES192_CBC = 'http://www.w3.org/2001/04/xmlenc#aes192-cbc';
    const AES256_CBC = 'http://www.w3.org/2001/04/xmlenc#aes256-cbc';
    const RSA_1_5 = 'http://www.w3.org/2001/04/xmlenc#rsa-1_5';
    const RSA_OAEP_MGF1P = 'http://www.w3.org/2001/04/xmlenc#rsa-oaep-mgf1p';
    const RSA_SHA1 = 'http://www.w3.org/2000/09/xmldsig#rsa-sha1';
    const DSA_SHA1 = 'http://www.w3.org/2000/09/xmldsig#dsa-sha1';


    private static function calculateX509Fingerprint($x509cert) {
            assert('is_string($x509cert)');

            $lines = explode("\n", $x509cert);

            $data = '';

            foreach($lines as $line) {
                    /* Remove '\r' from end of line if present. */
                    $line = rtrim($line);
                    if($line === '-----BEGIN CERTIFICATE-----') {
                            /* Delete junk from before the certificate. */
                            $data = '';
                    } elseif($line === '-----END CERTIFICATE-----') {
                            /* Ignore data after the certificate. */
                            break;
                    } elseif($line === '-----BEGIN PUBLIC KEY-----') {
                            /* This isn't an X509 certificate. */
                            return NULL;
                    } else {
                            /* Append the current line to the certificate data. */
                            $data .= $line;
                    }
            }

            /* $data now contains the certificate as a base64-encoded string. The fingerprint
             * of the certificate is the sha1-hash of the certificate.
             */
            return strtolower(sha1(base64_decode($data)));
    }


    /**
     * Helper function for validating the fingerprint.
     *
     * Checks the fingerprint of a certificate against an array of valid fingerprints.
     * Will throw an exception if none of the fingerprints matches.
     *
     * @param string $certificate  The X509 certificate we should validate.
     * @param array $fingerprints  The valid fingerprints.
     */
    public static function validateCertificateFingerprint($certificate, $fingerprints) {
            assert('is_string($certificate)');	
            assert('is_array($fingerprints)');

            $certFingerprint = self::calculateX509Fingerprint($certificate);

            if ($certFingerprint === NULL) {
                    /* Couldn't calculate fingerprint from X509 certificate. Should not happen. */
                    throw new Exception('Unable to calculate fingerprint from X509' .
                            ' certificate. Maybe it isn\'t an X509 certificate?');
            }

            foreach ($fingerprints as $fp) {
                    assert('is_string($fp)');

                    if ($fp === $certFingerprint) {
                            /* The fingerprints matched. */
                            return;
                    }

            }

            /* None of the fingerprints matched. Throw an exception describing the error. */
            throw new Exception('Invalid fingerprint of certificate. Expected one of [' .
                    implode('], [', $fingerprints) . '], but got [' . $certFingerprint . ']');
    }

    public function validateFingerprint($fingerprints) {
            assert('is_string($fingerprints) || is_array($fingerprints)');

            if($this->x509Certificate === NULL) {
                    ///throw new Exception('Key used to sign the message was not an X509 certificate.');
					echo 'Key used to sign the message was not an X509 certificate.';
					exit();
            }

            if(!is_array($fingerprints)) {
                    $fingerprints = array($fingerprints);
            }

            /* Normalize the fingerprints. */
            foreach($fingerprints as &$fp) {
                    assert('is_string($fp)');

                    /* Make sure that the fingerprint is in the correct format. */
                    $fp = strtolower(str_replace(":", "", $fp));
            }

            self::validateCertificateFingerprint($this->x509Certificate, $fingerprints);
    }

}
