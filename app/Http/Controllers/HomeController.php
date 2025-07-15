<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//service
use App\Models\Service;

class HomeController extends Controller
{
    public function index() {
       
        $meta = [
            'title' => 'NNK Sacco Limited – Empowering Your Financial Future',
            'description' => 'NNK Sacco Limited offers convenient and reliable financial solutions through affordable loans and savings plans. Join today to take control of your financial journey.',
            'keywords' => 'NNK Sacco Limited, Sacco Kenya, loan application, savings, financial solutions, cooperative, microfinance, member loans, Nairobi Sacco, trusted Sacco',
            'author' => 'NNK Sacco Limited',
            'image' => asset('images/og-image.jpg'),
            'url' => url('/'),
        ];

        return view('front.index', compact('meta'));
    }

    public function about() {
        $meta = [
            'title' => 'About NNK Sacco Limited',
            'description' => 'Learn more about NNK Sacco Limited, our mission, vision, and the values that drive us to provide exceptional financial services.',
            'keywords' => 'About NNK Sacco, NNK Sacco mission, NNK Sacco vision, financial services Kenya',
            'author' => 'NNK Sacco Limited',
            'image' => asset('images/about-og-image.jpg'),
            'url' => url('/about'),
        ];
        return view('front.about', compact('meta'));
    }

    public function team() {
        $meta = [
            'title' => 'Meet the Team at NNK Sacco Limited',
            'description' => 'Get to know the dedicated team behind NNK Sacco Limited and our commitment to serving you.',
            'keywords' => 'NNK Sacco team, meet the team, NNK Sacco staff',
            'author' => 'NNK Sacco Limited',
            'image' => asset('images/team-og-image.jpg'),
            'url' => url('/the-team'),
        ];
        return view('front.team', compact('meta'));
    }

    public function contact() {
        $meta = [
            'title' => 'Contact NNK Sacco Limited',
            'description' => 'Get in touch with NNK Sacco Limited for any inquiries or support.',
            'keywords' => 'Contact NNK Sacco, NNK Sacco support, NNK Sacco inquiries',
            'author' => 'NNK Sacco Limited',
            'image' => asset('images/contact-og-image.jpg'),
            'url' => url('/contact'),
        ];
        return view('front.contact', compact('meta'));
    }

    public function privacy() {
        $meta = [
            'title' => 'Privacy Policy - NNK Sacco Limited',
            'description' => 'Read our privacy policy to understand how we handle your personal information.',
            'keywords' => 'NNK Sacco privacy policy, data protection, user privacy',
            'author' => 'NNK Sacco Limited',
            'image' => asset('images/privacy-og-image.jpg'),
            'url' => url('/privacy-policy'),
        ];
        return view('front.privacy', compact('meta'));
    }

    public function terms() {
        $meta = [
            'title' => 'Terms and Conditions - NNK Sacco Limited',
            'description' => 'Review the terms and conditions governing your use of NNK Sacco Limited services.',
            'keywords' => 'NNK Sacco terms and conditions, user agreement, service terms',
            'author' => 'NNK Sacco Limited',
            'image' => asset('images/terms-og-image.jpg'),
            'url' => url('/terms-and-conditions'),
        ];
        return view('front.terms', compact('meta'));
    }

    public function copyright() {
        $meta = [
            'title' => 'Copyright - NNK Sacco Limited',
            'description' => 'Read about the copyright policy of NNK Sacco Limited.',
            'keywords' => 'NNK Sacco copyright, copyright policy',
            'author' => 'NNK Sacco Limited',
            'image' => asset('images/copyright-og-image.jpg'),
            'url' => url('/copyright-policy'),
        ];
        return view('front.copyright', compact('meta'));
    }

    public function services() {
        $meta = [
            'title' => 'Our Services - NNK Sacco Limited',
            'description' => 'Explore the range of financial services offered by NNK Sacco Limited.',
            'keywords' => 'NNK Sacco services, financial services Kenya',
            'author' => 'NNK Sacco Limited',
            'image' => asset('images/services-og-image.jpg'),
            'url' => url('/services'),
        ];
        return view('front.services', compact('meta'));
    }

    public function singleService($slung) {
        $service = Service::where('slung', $slung)->firstOrFail();
        $meta = [
            'title' => $service->title . ' | NNK Staff Sacco Limited',
            'description' => 'Explore NNK Sacco’s ' . strtolower($service->title) . ' – '.$service->meta.'',
            'keywords' => 'NNK Sacco, ' . $service->title . ', Sacco Services, Savings and Loans, Cooperative Kenya',
            'author' => 'NNK Staff Sacco Limited',
            'image' => asset('uploads/services/' . $service->image), // Prefer service-specific image
            'url' => url('/services/' . $service->slung),
        ];

        // Fetch specific service based on slung, e.g., from DB
        
        // return view('front.single-service', compact('service'));
        return view('front.single-service', compact('slung', 'meta','service'));
    }
}
