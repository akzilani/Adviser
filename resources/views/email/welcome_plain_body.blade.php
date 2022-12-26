{{ str_replace(["&nbsp;","&amp;", "&nbsp", "&amp" ], " ", strip_tags($mail_message ?? "")) }}

            Login Details
            Login URL : {{ url('/login') }}
            Email: {{ $advisor->email }}
            Password: ******** 

            
            Personal Information
                Full Name: {{ $advisor->first_name }} {{ $advisor->last_name }}
                Email: {{ $advisor->email }}
                Phone: {{ $advisor->phone }}
                Telephone: {{ $advisor->telephone }}
                Personal FCA: {{ $advisor->personal_fca_number }}
                Profession: {{ $advisor->profession->name ?? "" }}
                Plan: {{ $advisor->subscription_plan->name ?? "" }}
                Address Information
                Address Line One: {{ $advisor->address_line_one }}
                Address Line Two: {{ $advisor->address_line_two }}
                Town: {{ $advisor->town }}
                County: {{ $advisor->country }}
                Postcode: {{ $advisor->post_code }}
                Postcode Area Covered: {{ $advisor->postcodesCovered() }}
                Region: {{ $advisor->primary_reason->name ?? "" }}

                Firm Details
                Firm Name: {{ $advisor->firm_details->profile_name ?? "" }}
                Firm Details: {{ $advisor->firm_details->profile_details ?? "" }} 
                Firm FCA Number: {{ $advisor->firm_details->firm_fca_number ?? "" }} 
                Firm Website: {{ $advisor->firm_details->firm_website_address ?? "" }} 
                
                Minimum Fund Size: {{ $advisor->fund_size->name }}
                
                 

                Services Offered 
                @foreach($advisor->service_offered() as $offer)
                    {!! $offer->name !!} 
                @endforeach
                
                
                Billing Address 
                Name:  {{ $advisor->billing_info->contact_name ?? "" }} 
                Company name: {{ $advisor->billing_info->billing_company_name ?? "" }} 
                Company FCA Number: {{ $advisor->billing_info->billing_company_fca_number ?? "" }} 
                Address Line One: {{ $advisor->billing_info->billing_address_line_one ?? "" }} 
                Address Line Two: {{ $advisor->billing_info->billing_address_line_two ?? "" }} 
                Town: {{ $advisor->billing_info->billing_town ?? "" }} 
                County: {{ $advisor->billing_info->billing_country ?? "" }} 
                Postcode: {{ $advisor->billing_info->billing_post_code ?? "" }} 
                
                Regulated Advice
