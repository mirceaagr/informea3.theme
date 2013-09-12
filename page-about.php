<?php
/**
 * Template name: InfoMEA About page
 */
if(have_posts()): while(have_posts()) : the_post();
$about = get_page_by_title('About');
get_header();
?>
<div class="container">
 <ul class="breadcrumb">
   <li><a href="#"><?php echo bloginfo('name'); ?></a></li>
      <li><?php echo $about->post_title; ?></li>
</ul>

    <div class="row">

				<!-- NAVIGATION BOX -->
		    	<div class="span3">

	      			<!-- TABLE OF CONTENTS -->
	      			<div class="well">
	      				<h4>Contents</h4>
		      			<ul class="nav nav-list">
							<li class="active"><a href="#Introduction">Introduction</a></li>
							<li><a href="#process-and-governance">Process and Governance</a></li>
							<li><a href="#api_specifications">API specifications</a></li>
							<li><a href="#multimedia">Multimedia</a></li>
						</ul>
					</div>
				</div>

				<div class="span9" id="content">

		    		<!-- SECTIONS -->
		    		<section id="Introduction">
		    			<h2>Introduction</h2>
		    			The MEA IKM Initiative

The MEA Information and Knowledge Management (IKM) Initiative brings together Multilateral Environmental Agreements (MEA) to develop harmonized and interoperable information systems for the benefit of Parties and the environment community at large. The Initiative is facilitated by the United Nations Environment Programme. The MEA Steering Committee meets annually and provides strategic direction. Its Working Group meets periodically during the year and is responsible for the technical implementation of projects.
What is InforMEA?
<br><br>
InforMEA is the first project established by this Initiative. InforMEA harvests COP decisions and resolutions, news, events, MEA membership, national focal points, national reports and implementation plans from MEA secretariats and organizes this information around a set of agreed terms.
Stakeholders
<br><br>
The MEA IKM initiative currently includes 43 international and regional legally binding instruments from 17 Secretariats hosted by three UN organizations and the International Union for Conservation of Nature (IUCN). The Initiative invites and welcomes the participation of observers involved with MEA data and information, such as the Environmental Management Group (EMG), IUCN, World Conservation Monitoring Centre (WCMC), the International Institute for Sustainable Development (IISD), the Centre for International Environmental Law (CIEL), and the Center for International Earth Science Information Network (CIESIN – Columbia University)

		    		<section id="process-and-governance">
		    			<h2>Process and Governance</h2>
		    			<p> Meetings

The following meetings have been held:


Steering Committee Meetings
                                        <ul>
                                        <li>Fourth MEA IKM Steering Committee, 4-6 June 2013 in Montreux, Switzerland</li>
                                        <li>Third MEA IKM Steering Committee, 22-24 May 2012 in Montreux, Switzerland (SCM 3, Agenda and Participants, Recommendations)</li>
                                        <li>Second MEA IKM Steering Committee, 14-16 June 2011 in Glion, Switzerland (SCM 2, Agenda and Participants, Recommendations)</li>
                                        <li> First MEA IKM Steering Committee Meeting, 22-24 June 2010, Glion, Switzerland (SCM1, I Agenda & Participants, II Recommendations, III SCTORs, IV SCMembers)</li>
                                        </ul>
 
</p>
		    			<div class="thumbnail thumb-block">
		 
		    			</div>
		    		
		    		</section>

		    		<section id="api_specifications">
		    			<h2>API specifications</h2>
                                        From this page you can access the resources related to InforMEA API implementation

    Introduction
    Data harvesting from MEAs
    The InforMEA Toolkit
    The InforMEA Brand Manual

Introduction

The purpose of the InforMEA API is to establish a communication protocol between InforMEA database and its data providers, the MEAs. Currently, this is a one-way communication, with data flowing from the MEAs to the InforMEA database.

The underlying protocol used to transport data is based on the OData web protocol. Together with our initial MEA contributors we have agreed on the format of the envelope that is defined on top of OData. The specifications for this format are defined on this Google document.
Data harvesting from MEAs

Currently there are about 14 secretariats who have granted access to their data as web data service, using the OData web protocol. The exposed data consists of:
<ul>
    <li>Decisions – COP/MOP decisions as documents and metadata</li>
    <li>Meetings – COP/MOP or other events</li>
   <li> Contacts – List of National Focal Points (NFPs)</li>
   <li> Parties – Countries that are parties to the Convention</li>
</ul>

We are regularly harvesting this data and updating the InforMEA index with this data. The status of this harvesing can be found on this Google document.
		    		
		    		</section>
<section id="multimedia">
		    			<h2>Multimedia</h2>
                                        
                                        <ul>
                                            <li> Introduction</li>
                                            <li> Process and governance</li>
                                            <li>API specifications</li>
                                            <li>Multimedia</li>
                                            <li> Design proposals</li>
                                            </ul>
InforMEA multimedia resources

    Outreach print materials (brochures, posters, folder etc.) – ZIP archive (~20MB)
    InforMEA branding guidelines v. 1.2.1 – PDF file (~10MB)

Steering Committee Meetings

    Third MEA IKM Steering Committee, 22 -24 June 2012 in Montreux, Switzerland
    Presentations:
    <ol>
        <li> Introduction and a brief history of the MEA IKM initiative.</li>
        <li>EIONET – European Environmental Information and Observation Network.</li>
        <li>Update on CBD development related to the MEA IKM initiative.</li>
        <li>[Presentation 4]</li>
        <li>UNESCO Online Strategy & Implementation Plan.</li>
        <li> An overview of the UNEP Live platform prototype.</li>
        <li> Update by the IKM Team.</li>
        <li> Fundraising Efforts.</li>
        <li> User Experience & Usability.</li>
        <li> The Carpathian Convention Reporting & Information Management Issues – Biodiversity and Climate Change.</li>
        <li> The Single Window Initiative.</li>
    </ol>

    <b> Second MEA IKM Steering Committee, 14-16 June 2011 in Glion, Switzerland
    Presentations:</b>
    <ol>
        <li>The MEA Information and Knowledge Management (IKM) Initiative</li>
        <li>CITES Virtual College</li>
        <li>UNEP-WCMC Online Reporting Tool</li>
        <li> UNCCD PRAIS Project</li>
        <li> InforMEA Technical Components</li>
    </ol>

    First MEA IKM Steering Committee Meeting, 22-24 June 2010, Glion, Switzerland
    Presentations:
    <ol>
        <li> The MEA Information and Knowledge Management (IKM) Initiative </li>
        <li>  Information and Knowledge Management at the UNFCCC Secretariat </li>
        <li>  Outcomes from the UNEP Knowledge Managment retreat and roles of MEAs</li>
        <li>  Portal Information Architecture</li>
        <li>  Information Exchange API Options</li>
        <li> Information Exchange API Formats</li>
        <li>  Presentation on Interim Solutions for MEAs with Less Capacity</li>
        <li> MEA Controlled Vocabulary – Working Version 5</li>
        <li> Presentation on an MEA IKM toolkit</li>
        <li> Presentation on the MEA Analytical Index</li>
        <li> Presentation on Online National Reporting for MEAs</li>
        <li> Presentation on an MEA Virtual University</li>
    </ol>
 <i> Picture gallery</i>
</section>

		    	</div>
		    </div>
		</div>

<?php
endwhile; endif;
get_footer();
?>