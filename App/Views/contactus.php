<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="./css/loginformstyle.css">
    <script src="./js/contactus.js" defer></script>
</head>
<body>
    <div class="main">
        <div class="main_box">
            <div class="leftside">
                <h1 style="color:rgb(34, 139, 34);">Contact Us</h1>
                <h3>We invite you to inquire about any product or service you are interested in.</h3>
                <h5>We aim to respond to all inquiries within regular business hours on weekdays</h5>
                <div class="scroll-indicator">
                    <br>
                    <a href="#details" onclick="scrollToDetails(event)">
                        <p>Click here for more details</p>
                        <i class="arrow-down"></i>
                    </a>
                </div>
            </div>
            <hr>
            <div class="rightside">
                <form name="contactus" action="#" method="post">
                    <table class="table">
                        <tr>
                            <td class="label-cell"><label for="name">Name</label></td>
                            <td class="input-cell"><input type="text" id="name" name="name" placeholder="Name"></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="email">Email</label></td>
                            <td class="input-cell"><input type="text" id="email" name="email" placeholder="Email"></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="contactno">Phone</label></td>
                            <td class="input-cell"><input type="text" id="contactno" name="contactno" placeholder="(Optional)"></td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="type">Type</label></td>
                            <td class="input-cell">
                                <select>
                                    <option default value="Choose option">Choose Option</option>
                                    <option value="feedback">Feedback</option>
                                    <option value="question">Question</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="label-cell"><label for="message">Message</label></td>
                            <td class="input-cell"><textarea class="myTextarea" rows="4" placeholder="Enter your message"></textarea></td>
                        </tr>
                        <?php if (isset($_SESSION['error'])) { ?>
                            <tr>
                                <td colspan="2"><p style="color: red; text-align: center; margin-top: 10px; margin-bottom:0px"><?php echo $_SESSION['error']; ?></p></td>
                            </tr>
                        <?php } ?>
                        <tr class="button">
                            <td colspan="2"><button type="submit">Submit</button></td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <div id="details" class="contact-details"> 
        <h2>Contact Details</h2>
        <p>241 /6 /1, Sama Mawatha, Mattegoda<br>Srilanka</p>
        <p>+94 (71) 5286-XXX</p>
        <p>support@ecap.com</p>
    </div>
    <div class="map">
    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d1980.76712141372!2d79.96932498299404!3d6.826356661587588!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2slk!4v1733332728656!5m2!1sen!2slk" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
</body>
</html>
