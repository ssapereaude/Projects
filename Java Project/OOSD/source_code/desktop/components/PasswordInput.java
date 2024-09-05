/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package components;

import java.awt.Color;
import javax.swing.BorderFactory;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.JPasswordField;
import utils.Colors;
import utils.Fonts;

public class PasswordInput extends JPanel {

    final int PADDING_X = 20;
    final int PADDING_Y = 10;

    JLabel label;
    JPanel panel;
    JPasswordField passwordField;

    public PasswordInput(String labelText, int x, int y, int width, int inputHeight) {
        this.setBounds(x, y, width, inputHeight * 2);
        this.setLayout(null);
        this.setBackground(Colors.BG);

        /* label */
        label = new JLabel(labelText);
        label.setBounds(0, 0, width, inputHeight);
        label.setForeground(Colors.TEXT);
        label.setFont(Fonts.LABEL);
        this.add(label);

        /* panel */
        panel = new JPanel();
        panel.setBounds(0, inputHeight, width, inputHeight);
        panel.setBorder(BorderFactory.createLineBorder(Colors.GRAY_LIGHT));
        panel.setBackground(Colors.BG);
        panel.setLayout(null);

        /* password field */
        passwordField = new JPasswordField();
        passwordField.setBounds(PADDING_X, PADDING_Y, width - PADDING_X * 2, inputHeight - PADDING_Y * 2);
        passwordField.setFont(Fonts.DEFAULT);
        passwordField.setBackground(Colors.BG);
        passwordField.setForeground(Colors.TEXT);
        passwordField.setBorder(null);
        passwordField.setFont(Fonts.DEFAULT);
        panel.add(passwordField);

        this.add(panel);

    }

    public void clear() {
        passwordField.setText("");
    }

    public String getPassword() {
        return String.valueOf(passwordField.getPassword());
    }

    public void setBorderColor(Color color) {
        panel.setBorder(BorderFactory.createLineBorder(color));
    }

}
