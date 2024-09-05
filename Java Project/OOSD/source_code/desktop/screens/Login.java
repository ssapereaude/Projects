/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package screens;

import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JPasswordField;
import javax.swing.JTextField;
import components.Button;
import javax.swing.BorderFactory;
import javax.swing.ImageIcon;
import java.awt.Cursor;
import java.awt.event.ActionEvent;
import java.awt.event.ActionListener;
import java.io.BufferedReader;
import java.io.InputStreamReader;
import java.net.HttpURLConnection;
import java.net.URL;
import utils.Colors;
import utils.Fonts;
import utils.User;
import utils.Window;
import utils.exceptions.EmptyInputException;
import utils.exceptions.LoginException;

public class Login extends JPanel implements ActionListener {

    final int INPUT_WIDTH = 300;
    final int INPUT_HEIGHT = 46;
    final int IMAGE_WIDTH = 340;
    final int IMAGE_HEIGHT = 360;

    JLabel image;
    JLabel title;
    JTextField usernameField;
    JPasswordField passwordField;
    Button submitBtn;
    JPanel[] inputBox;
    JLabel icon;
    boolean isProcessing;
    JLabel errorMessage;

    private void checkInputsNotEmpty() throws EmptyInputException {
        /* check that username is not empty */
        if (usernameField.getText().length() == 0) {
            inputBox[0].setBorder(BorderFactory.createLineBorder(Colors.RED));
            throw new EmptyInputException("Username is empty");
        }

        /* check that password is not empty */
        if (passwordField.getPassword().length == 0) {
            inputBox[1].setBorder(BorderFactory.createLineBorder(Colors.RED));
            throw new EmptyInputException("Password is empty");
        }
    }

    private boolean login() {
        try {
            /* check that inputs are not empty */
            checkInputsNotEmpty();

            /* check login credentials */
            URL obj = new URL("http://localhost:3000/api/login?username=" + usernameField.getText() + "&password="
                    + String.valueOf(passwordField.getPassword()));
            HttpURLConnection con = (HttpURLConnection) obj.openConnection();
            con.setRequestMethod("GET");
            con.setRequestProperty("User-Agent", "Mozilla/5.0");
            int responseCode = con.getResponseCode();

            if (responseCode == HttpURLConnection.HTTP_OK) {
                BufferedReader in = new BufferedReader(new InputStreamReader(con.getInputStream()));
                String inputLine;
                StringBuffer response = new StringBuffer();

                while ((inputLine = in.readLine()) != null) {
                    response.append(inputLine);
                }
                in.close();

                if (response.toString().compareTo("null") == 0) {
                    throw new LoginException("Wrong username or password");
                } else {
                    /* successful login */
                    return true;
                }
            } else {
                throw new LoginException("Wrong username or password");
            }
        } catch (Exception e) {
            e.printStackTrace();
            errorMessage.setText(e.getMessage());
            isProcessing = false;
            passwordField.setText("");
            submitBtn.setIsEnabled(true);
            return false;
        }
    }

    public void actionPerformed(ActionEvent e) {
        if (e.getSource() == submitBtn) {
            for (JPanel input : inputBox) {
                input.setBorder(BorderFactory.createLineBorder(Colors.GRAY_LIGHT));
            }
            // login
            submitBtn.setIsEnabled(false);
            Window.frame.setCursor(Cursor.DEFAULT_CURSOR);
            isProcessing = true;

            // login
            if (login()) {
                User.setUsername(usernameField.getText());
                Window.frame.remove(this);
                Window.frame.add(new MainScreen());
                Window.frame.revalidate();
                Window.frame.repaint();
            }
        }
    }

    public Login() {
        isProcessing = false;
        this.setBackground(Colors.BG);
        this.setBounds(0, 0, Window.WINDOW_WIDTH, Window.WINDOW_HEIGHT);
        this.setLayout(null);

        inputBox = new JPanel[2];
        for (int i = 0; i < inputBox.length; i++) {
            inputBox[i] = new JPanel();
            inputBox[i].setBackground(Colors.BG);
            inputBox[i].setBorder(BorderFactory.createLineBorder(Colors.GRAY_LIGHT));
            inputBox[i].setBounds((int) (1.5 * Window.WINDOW_WIDTH - INPUT_WIDTH) / 2, 230 + i * 80, INPUT_WIDTH,
                    INPUT_HEIGHT);
            inputBox[i].setLayout(null);
        }

        /* image */
        image = new JLabel(new ImageIcon("images/logo-lg.png"));
        image.setBounds(((Window.WINDOW_WIDTH / 2) - IMAGE_WIDTH) / 2, (Window.WINDOW_HEIGHT - IMAGE_HEIGHT) / 2 - 50,
                IMAGE_WIDTH, IMAGE_HEIGHT);
        this.add(image);

        /* title */
        title = new JLabel("Login");
        title.setForeground(Colors.TEXT);
        title.setFont(Fonts.TITLE);
        title.setIcon(null);
        title.setBounds((int) (1.5 * Window.WINDOW_WIDTH - INPUT_WIDTH) / 2, 150, INPUT_WIDTH, INPUT_HEIGHT);
        title.setHorizontalAlignment(0);
        this.add(title);

        /* username */
        icon = new JLabel(new ImageIcon("images/user.png"));
        icon.setBounds((INPUT_HEIGHT - 20) / 2, (INPUT_HEIGHT - 20) / 2, 20, 20);
        inputBox[0].add(icon);
        usernameField = new JTextField();
        usernameField.setBounds(40 + (INPUT_HEIGHT - 20) / 2, 3, INPUT_WIDTH - 60 - (INPUT_HEIGHT - 20) / 2,
                INPUT_HEIGHT - 6);
        usernameField.setBackground(Colors.BG);
        usernameField.setForeground(Colors.TEXT);
        usernameField.setFont(Fonts.DEFAULT);
        usernameField.setBorder(null);
        inputBox[0].add(usernameField);
        this.add(inputBox[0]);

        /* password */
        icon = new JLabel(new ImageIcon("images/lock.png"));
        icon.setBounds((INPUT_HEIGHT - 20) / 2, (INPUT_HEIGHT - 20) / 2, 20, 20);
        inputBox[1].add(icon);
        passwordField = new JPasswordField();
        passwordField.setBounds(40 + (INPUT_HEIGHT - 20) / 2, 3, INPUT_WIDTH - 60 - (INPUT_HEIGHT - 20) / 2,
                INPUT_HEIGHT - 6);
        passwordField.setBackground(Colors.BG);
        passwordField.setForeground(Colors.TEXT);
        passwordField.setFont(Fonts.DEFAULT);
        passwordField.setBorder(null);
        inputBox[1].add(passwordField);
        this.add(inputBox[1]);

        /* submit button */
        submitBtn = new Button("Login");
        submitBtn.setBounds((int) (1.5 * Window.WINDOW_WIDTH - INPUT_WIDTH) / 2, 450, INPUT_WIDTH, INPUT_HEIGHT);
        submitBtn.setFont(Fonts.DEFAULT);
        submitBtn.setBackground(Colors.PRIMARY);
        submitBtn.setForeground(Colors.BG);
        submitBtn.addActionListener(this);
        this.add(submitBtn);

        /* error message */
        errorMessage = new JLabel("");
        errorMessage.setBounds((int) (1.5 * Window.WINDOW_WIDTH - INPUT_WIDTH) / 2, 530, INPUT_WIDTH, INPUT_HEIGHT);
        errorMessage.setFont(Fonts.DEFAULT);
        errorMessage.setForeground(Colors.RED);
        errorMessage.setHorizontalAlignment(0);
        this.add(errorMessage);

    }

}