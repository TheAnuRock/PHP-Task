<?php namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\UserModel;

class Join extends Controller {
    public function index() {
        return view('join');
    }

    public function register() {
        $email = $this->request->getPost('email');
        $otp = rand(100000, 999999);
        session()->set('otp', $otp);
        session()->set('email', $email);

        // Send OTP
        $emailService = \Config\Services::email();
        $emailService->setTo($email);
        $emailService->setSubject('Your OTP Code');
        $emailService->setMessage("Your OTP is: $otp");
        if ($emailService->send()) {
            return view('verify');
        } else {
            return "Error sending email.";
        }
    }

    public function verify() {
        $inputOtp = $this->request->getPost('otp');
        if ($inputOtp == session()->get('otp')) {
            return view('success');
        } else {
            return "Invalid OTP";
        }
    }
}
