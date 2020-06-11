<form id="ajax-contact-form" method="post" action="">
    <div class="note"></div>
    <div class="form-row">
        <label for="name">Full name:</label>
        <input class="form-control" required="" type="text" name="name" id="name" placeholder="Full name" />
    </div>
    <div class="form-row">
        <label for="email">Email:</label>
        <input class="form-control" required="" type="email" name="email" id="email" placeholder="Email address" />
    </div>
    <div class="form-row">
        <label for="name">Subject:</label>
        <select class="form-control" required="" name="subject">
            <option value="">Subject</option>
            <option value="booking">Booking</option>
            <option value="enquiry">Enquiry</option>
        </select>
    </div>
    <div class="form-row">
        <label for="message">Message:</label>
        <textarea class="form-control" required="" name="message" id="message" placeholder="Write your message..."></textarea>
    </div>
    <div class="">
        <button type="reset" class="btn dark_btn">Clear form</button>
        <button type="submit" class="btn btn-danger send_btn">Send</button>
    </div>
</form>