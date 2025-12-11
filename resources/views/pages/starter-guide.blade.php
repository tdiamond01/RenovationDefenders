<x-app-layout>
    <style>
        .guide-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px 20px;
            text-align: center;
            margin: -1.5rem -0.75rem 2rem;
        }
        .guide-hero h1 {
            font-size: 2.5rem;
            margin-bottom: 15px;
        }
        .guide-hero .tagline {
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
        }
        .section-header {
            text-align: center;
            margin-bottom: 40px;
        }
        .section-header h2 {
            font-size: 2rem;
            color: #667eea;
            margin-bottom: 10px;
        }
        .section-header .subtitle {
            color: #666;
            font-size: 1.1rem;
        }
        .topics-list {
            list-style: none;
            padding: 0;
            max-width: 800px;
            margin: 0 auto;
        }
        .topics-list li {
            padding: 15px 20px;
            margin-bottom: 10px;
            background: white;
            border-left: 4px solid #764ba2;
            border-radius: 0 5px 5px 0;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .example-box {
            background: white;
            border: 2px solid #764ba2;
            border-radius: 10px;
            padding: 30px;
            margin: 30px auto;
        }
        .example-box h3 {
            color: #667eea;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f5f5f5;
        }
        .example-box h4 {
            color: #764ba2;
            margin-top: 20px;
            margin-bottom: 10px;
        }
        .checklist-item {
            display: flex;
            align-items: flex-start;
            padding: 15px;
            margin-bottom: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .checklist-number {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            font-weight: bold;
            border-radius: 50%;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .agreement-item {
            padding: 15px 20px 15px 50px;
            margin-bottom: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            position: relative;
        }
        .agreement-item::before {
            content: "\2713";
            position: absolute;
            left: 18px;
            color: #764ba2;
            font-size: 1.3rem;
            font-weight: bold;
        }
        .guide-section {
            padding: 40px 0;
        }
        .guide-section:nth-child(even) {
            background: #f8f9fa;
            margin: 0 -0.75rem;
            padding: 40px 20px;
        }
        .guide-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            height: 100%;
        }
        .guide-card h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 1.2rem;
        }
        .guide-card ul {
            padding-left: 20px;
            margin-bottom: 0;
        }
        .guide-card li {
            margin-bottom: 8px;
        }
    </style>

    <!-- Hero Section -->
    <div class="guide-hero">
        <div class="container">
            <h1>Starter Guide</h1>
            <p class="tagline">We're on a mission to save homeowners thousands of dollars by avoiding scams and tricks contractors and companies use to take our hard-earned money.</p>
        </div>
    </div>

    <div class="container">
        <!-- Introduction -->
        <div class="guide-section">
            <div class="section-header">
                <h2>Protect Your Renovation Projects</h2>
                <p class="subtitle">This guide grants you the ability to uncover scams, malpractice, and costly behavior that has plagued millions of homeowners across the country.</p>
            </div>
        </div>

        <!-- Section 1: Define Your Scope -->
        <div class="guide-section">
            <div class="section-header">
                <h2>1. Define Your Scope</h2>
                <p class="subtitle">Know exactly what you are looking for in your home renovation project by doing this first.</p>
            </div>

            <h4 class="text-center mb-4" style="color: #764ba2;">Topics Covered</h4>

            <ul class="topics-list">
                <li>The first step to writing your personal scope</li>
                <li>The importance of writing things down</li>
                <li>Writing an example personal scope</li>
                <li>What is a priority list</li>
                <li>Writing out the priority list</li>
                <li>Priorities can be different from person to person</li>
                <li>Working through the budget</li>
                <li>Optimizing the budget, getting better prices</li>
                <li>Two ways to adjust the budget (Priorities + Materials)</li>
                <li>Talking to your local building inspector</li>
                <li>Blueprints vs Sketches</li>
                <li>Navigating electrical and plumbing drawings</li>
            </ul>

            <!-- Example: Kitchen Renovation -->
            <div class="example-box">
                <h3>Example: Kitchen Renovation Project</h3>

                <h4>Step 1: Write a brief description "in your own words"</h4>
                <p class="fst-italic mb-4">What do you want this to look like in the end? We want the kitchen to look bigger, take down some walls, swap out the kitchen cabinets & countertops, swap out the backsplash - would love to upgrade the lighting work, we WANT to increase natural lighting, and swap the flooring out too!</p>

                <h4>Step 2: Schedule of Priorities</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Priority</th>
                                <th>Renovation</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>1</td><td>Countertops/Cabinets/Backsplash</td></tr>
                            <tr><td>2</td><td>Take down the wall</td></tr>
                            <tr><td>3</td><td>Swap out the lighting (fan fixture)</td></tr>
                            <tr><td>4</td><td>Increase natural lighting (upgrade the windows)</td></tr>
                            <tr><td>5</td><td>Upgrade the flooring</td></tr>
                            <tr><td>6</td><td>Painting Scheme</td></tr>
                            <tr><td>7</td><td>Dishwasher</td></tr>
                        </tbody>
                    </table>
                </div>

                <h4>Step 3: Budget</h4>
                <p><strong>$20,000 Cash</strong> | <strong>$40,000 Line of Credit</strong></p>
                <p class="mt-2">How much do you think you can afford? What's your maximum amount that you will go to? That's why we have our list of priorities - we can cut certain things out on the values of our priorities.</p>

                <h4>Budget Important Notes</h4>
                <p>Two ways to adjust your budget:</p>
                <ol class="ms-3 mt-2">
                    <li>Take things out in priorities list</li>
                    <li>Materials - Example: Hardwood cabinets are going to be more than plywood. Countertops have dramatic price changes. Flooring: Tile vs Hardwood vs Vinyl</li>
                </ol>

                <h4>Next: Ask the Building Inspector (This is Free)</h4>
                <ol class="ms-3">
                    <li>Yes, we need a permit</li>
                    <li>Yes, we need blueprints</li>
                </ol>
                <p class="mt-2 fst-italic">Remember: The inspection and the plumber is going to the inspector's inspection.</p>
            </div>
        </div>

        <!-- Section 2: Interview Contractors -->
        <div class="guide-section">
            <div class="section-header">
                <h2>2. Interview Contractors</h2>
                <p class="subtitle">Use our step by step checklist to help you filter out the good vs the bad contractors.</p>
            </div>

            <h4 class="text-center mb-4" style="color: #764ba2;">Topics Covered</h4>

            <ul class="topics-list">
                <li>Getting 3 competitive bidders</li>
                <li>The importance of writing things down</li>
                <li>Setting a date to meet with Contractors</li>
                <li>Why how long they have been in business is important</li>
                <li>Properly investigating names and references</li>
                <li>Double-checking the insurance</li>
                <li>Ensuring that additional insured is listed</li>
                <li>The must-have for sub-contractor insurance</li>
                <li>Having peace of mind that contractors are pulling permits</li>
                <li>Defining a separate list of materials on the project</li>
                <li>Filtering through the weeds with a background check</li>
                <li>Dodging the headache of a finance company</li>
                <li>Using full-time employees as a gauge for capability</li>
                <li>The paramount check of the license</li>
                <li>Keeping the site clean from cigarettes and drugs</li>
                <li>Checking off the start date</li>
            </ul>

            <!-- Contractor Interview Checklist -->
            <div class="example-box mt-5">
                <h3>Contractor Interview Checklist</h3>

                <div class="checklist-item"><span class="checklist-number">1</span><span>How long have you been in business? (Under the name they have now)</span></div>
                <div class="checklist-item"><span class="checklist-number">2</span><span>Do you have any recommendations and references? (Get their name and #)</span></div>
                <div class="checklist-item"><span class="checklist-number">3</span><span>Do you have business insurance with workmans comp, liability, and umbrella coverage?</span></div>
                <div class="checklist-item"><span class="checklist-number">4</span><span>Can you list me as additionally insured and get me an insurance certificate stating that?</span></div>
                <div class="checklist-item"><span class="checklist-number">5</span><span>Will all your subcontractors also have insurance and add me as additionally insured?</span></div>
                <div class="checklist-item"><span class="checklist-number">6</span><span>How do you handle permits? (All permits always attained by the contractor)</span></div>
                <div class="checklist-item"><span class="checklist-number">7</span><span>Will you let us know what materials are needed and also let us buy our own materials?</span></div>
                <div class="checklist-item"><span class="checklist-number">8</span><span>Can I run a background check on you?</span></div>
                <div class="checklist-item"><span class="checklist-number">9</span><span>Is there a financing company involved?</span></div>
                <div class="checklist-item"><span class="checklist-number">10</span><span>How many employees do you have and what is your office location?</span></div>
                <div class="checklist-item"><span class="checklist-number">11</span><span>Can I get a copy of your general contractor's license & Social Security #?</span></div>
                <div class="checklist-item"><span class="checklist-number">12</span><span>Do you agree to keep a clean work environment that is smoke & drug free?</span></div>
                <div class="checklist-item"><span class="checklist-number">13</span><span>Tell the contractor here's the date you want to start, and is that acceptable to them?</span></div>
            </div>
        </div>

        <!-- Section 3: The Rider -->
        <div class="guide-section">
            <div class="section-header">
                <h2>3. The Rider</h2>
                <p class="subtitle">The flagship product, the most powerful tool in your pro protection packet.</p>
            </div>

            <h4 class="text-center mb-4" style="color: #764ba2;">Topics Covered</h4>

            <div class="row g-4 mb-5">
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>Documentation</h3>
                        <ul>
                            <li>What is a Summary of Work</li>
                            <li>Why a certificate of insurance important</li>
                            <li>Overview of handling materials</li>
                            <li>Watching out for fixed line items</li>
                            <li>Getting licenses & insurance from all subcontractors</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>Work & Payments</h3>
                        <ul>
                            <li>Why it's important to get hourly rates for all trades</li>
                            <li>Ensuring additional work is approved beforehand in writing</li>
                            <li>How to work in a warranty with General Contractors</li>
                            <li>Making sure that work is done properly to code</li>
                            <li>The importance of waste disposal and removal</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>Payments & Requests</h3>
                        <ul>
                            <li>Why getting requests for payment in writing is a must-do</li>
                            <li>What to do about dealing with damages caused by contractors on-site</li>
                            <li>Taking dated pictures before, during, and after as "assurance"</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>Contracts & Disputes</h3>
                        <ul>
                            <li>The must-do of implementing Mandatory Binding Arbitration</li>
                            <li>The dangers of not using Mandatory Binding Arbitration</li>
                            <li>Why you should quote out changes before doing them</li>
                            <li>Protecting both parties with change requests being in writing</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>Project Management</h3>
                        <ul>
                            <li>Directing the storage of materials, and why?</li>
                            <li>The importance of written timeframes start/complete</li>
                            <li>When can projects be extended?</li>
                            <li>Dealing with substandard work</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>Living Arrangements</h3>
                        <ul>
                            <li>What is a written work plan for?</li>
                            <li>A quick note about "typical construction standards"</li>
                            <li>When it's okay for the contractor to request payment</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- The Contractor Agrees To -->
            <div class="example-box">
                <h3>The Contractor Agrees To:</h3>

                <div class="agreement-item">Deliver a summary on how work is going to be done in phases</div>
                <div class="agreement-item">Must supply the owner with a certificate of insurance of workmans comp and liability insurance. This insurance certificate is a $1,000,000 umbrella. Insurance certificate must list owners of the property listed as additionally insured</div>
                <div class="agreement-item">Give a proposal of all labor & a separate proposal for all materials to complete this contract</div>
                <div class="agreement-item">Give the owner a fixed line item proposal for each task & give the owner a complete list of all materials to complete this contract</div>
                <div class="agreement-item">Ensure all subcontractors supply licenses as required and certificates of insurance. The owner must be added to the insurance certificates as additionally insured</div>
                <div class="agreement-item">Submit hourly rates for all trades for extra work in writing</div>
                <div class="agreement-item">Gain the owner's approval in writing before any work outside the base contract & will supply all labor and equipment required to fulfill the contract</div>
                <div class="agreement-item">Give the owner a warranty for at least 1 year after work is completed & any damage to the owners project or property by the contractor must be repaired to original status at no cost to the owner</div>
                <div class="agreement-item">Bring any defective work or work that doesn't pass inspection, up to code at no cost to the owner</div>
                <div class="agreement-item">Include all waste & debris disposal in their proposal unless it's excluded by the owner in writing</div>
                <div class="agreement-item">Attain the construction permit unless a permit is not needed</div>
                <div class="agreement-item">Submit request for payment in writing (email and hard copy)</div>
                <div class="agreement-item">Repair any damage to the property immediately to its previous condition at no cost to the owner</div>
                <div class="agreement-item">Mandatory Binding Arbitration to settle any disputes that may arise (Any Arbitration costs are split between the parties) - The Parties agree to accept the findings from the Arbitrator</div>
                <div class="agreement-item">Quote any change requests to the owner before performing them in writing & the owner must accept them in writing</div>
                <div class="agreement-item">Allow the owner to direct storage of any materials</div>
                <div class="agreement-item">Clean the work area at the end of each day</div>
                <div class="agreement-item">Give a written time frame when the project will start and when it will be completed</div>
                <div class="agreement-item">Fix any sub-standard work, or else the Owner may hire a different new contractor (And will back charge the invoice with any costs associated with the fix)</div>
                <div class="agreement-item">Give the owner a written work plan</div>
                <div class="agreement-item">Receive a penalty of $____ a day for every day the project goes uncompleted beyond the timeline (Unless the timeline is extended due to Natural or Man-Made Disasters or Logistics in retaining materials)</div>
                <div class="agreement-item">Comply with typical constructions standards</div>
                <div class="agreement-item">Give the owner a request for payment, in writing, 3 days before a payment is made so the work can be inspected by the owner OR the owner's representative</div>
                <div class="agreement-item">Keep a smoke-free, swearing-free, drug-free environment inside of the property</div>
                <div class="agreement-item">Receive a bonus of $___ / __% for completing the project within the proposed timeline</div>
                <div class="agreement-item">Before the final payment is made the contractor must submit a signed lien waiver that the owner will supply</div>
            </div>
        </div>

        <!-- Section 4: Recovery & Remedy -->
        <div class="guide-section">
            <div class="section-header">
                <h2>4. Recovery & Remedy</h2>
                <p class="subtitle">Not all projects go right, fortunately, you have some potential tools at your disposal.</p>
            </div>

            <h4 class="text-center mb-4" style="color: #764ba2;">Topics Covered</h4>

            <ul class="topics-list">
                <li>Introduction to Mandatory Binding Arbitration</li>
                <li>Working with demand letters</li>
                <li>Dealing with the costs of demand letters</li>
                <li>Preparing for the pain you will experience without having Mandatory Binding Arbitration</li>
                <li>Navigating the complex problem of evidence</li>
                <li>Why when it's "No contract Signed" - WATCH OUT</li>
                <li>Why the Attorney General's Office probably won't save you (toothless tiger)</li>
                <li>For small amounts, you can go to small claims (A good option?)</li>
                <li>Remedy Step 1: Negotiation</li>
                <li>Remedy Step 2: Demand Letter</li>
                <li>Remedy Step 3: Contacting an Arbitrator</li>
            </ul>
        </div>

        <!-- Lien Waiver Section -->
        <div class="guide-section">
            <div class="section-header">
                <h2>General Release of Liability and Waiver of Lien</h2>
                <p class="subtitle">Important legal protection for homeowners</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>1. Consideration</h3>
                        <p>In consideration the contractor agrees to not file a Mechanics lien. The Contractor releases and forever discharges the Home Owner from all manner of actions, causes of action, debts, accounts, bonds, contracts, claims and demands.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>2. Details of Dispute</h3>
                        <p>The claim or dispute occurred as a result of: [To be filled in as needed]</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>3. Concurrent Release</h3>
                        <p>The contractor acknowledges that this release is given with the express intention of effecting the extinguishment of certain obligations owed to the Contractor.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>4. Full and Final Settlement</h3>
                        <p>The parties to this Agreement further agree not to make claim or take proceedings against any other person or corporation which might claim contribution or indemnity.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>5. No Admission of Liability</h3>
                        <p>It is agreed that the payment is not deemed to be an admission of liability on the part of the Home Owner.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4">
                    <div class="guide-card">
                        <h3>6. Governing Law</h3>
                        <p>This agreement will be governed by and construed in accordance with the laws of the Commonwealth of Massachusetts.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disclaimer -->
        <div class="guide-section">
            <div class="alert alert-secondary">
                <p class="mb-0"><strong>Important:</strong> Our Program (including this packet) includes PDFs, Documents, Email, Video, Audio, and other digital & printed content. This material is designed to provide accurate and authoritative information in regard to the subject matter covered. It is provided with the understanding that the content creators (Renovation Defenders, etc.) are not engaged in rendering legal, accounting, or other professional services. If legal advice or other expert assistance is required, the services of a licensed professional should be sought.</p>
            </div>
        </div>
    </div>
</x-app-layout>
